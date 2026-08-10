/*=========================================================
                    PRODUCTS PAGE
=========================================================*/

/*=========================================================
                    DOM ELEMENTS
=========================================================*/

const loader = document.getElementById("loader");

function showLoader() {
    if (loader) loader.classList.add("active");
    document.body.classList.add('loading');
}

function hideLoader() {
    if (loader) loader.classList.remove("active");
    document.body.classList.remove('loading');
}

const productsGrid = document.getElementById("productsGrid");
const categoryButtons = document.querySelectorAll(".category-btn");
const searchInput = document.getElementById("productSearch");
const sortDropdown = document.querySelector(".sort-dropdown");
const sortBtn = document.getElementById("sortBtn");
const sortMenu = document.getElementById("sortMenu");
const selectedSort = document.getElementById("selectedSort");
const showingCount = document.getElementById("showingCount");
const totalCount = document.getElementById("totalCount");
const pagination = document.getElementById("pagination");
const noProducts = document.getElementById("noProducts");
const gridViewBtn = document.getElementById("gridView");
const listViewBtn = document.getElementById("listView");

/*=========================================================
                    VARIABLES
=========================================================*/

let products = [];
let filteredProducts = [];
let currentCategory = "all";
let currentSearch = "";
let currentSort = "default";
let currentView = "grid";
let currentPage = 1;
const productsPerPage = 9;

/*=========================================================
                LOAD PRODUCTS JSON
=========================================================*/

async function loadProducts() {
    showLoader();
    try {

        const response = await fetch("api/products.php");

        const data = await response.json();

        products = data.products || [];

        filteredProducts = [...products];

        currentPage = 1;

        initializeProducts();

    }
    catch (error) {

        console.error("Unable to load products.", error);

    }
    finally {
        hideLoader();
    }

}

/*=========================================================
                INITIALIZE PAGE
=========================================================*/

function initializeProducts() {
    applyFilters();
}

/*=========================================================
                CATEGORY FILTER
=========================================================*/

categoryButtons.forEach(button => {
    button.addEventListener("click", function () {
        categoryButtons.forEach(btn => {
            btn.classList.remove("active");
        });
        this.classList.add("active");
        currentCategory = this.dataset.category;
        currentPage = 1;
        applyFilters();
        if (window.innerWidth < 767) {
            productsGrid.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    });
});

/*=========================================================
                    SEARCH
=========================================================*/

if (searchInput) {
    searchInput.addEventListener("keyup", function () {
        currentSearch = this.value.trim().toLowerCase();
        currentPage = 1;
        applyFilters();
    });
}

/*=========================================================
                    SORTING
=========================================================*/

if (sortBtn && sortDropdown) {
    sortBtn.addEventListener("click", () => {
        sortDropdown.classList.toggle("active");
    });
}

document.querySelectorAll("#sortMenu li").forEach(item => {
    item.addEventListener("click", function () {
        if (selectedSort) selectedSort.textContent = this.textContent;
        currentSort = this.dataset.sort;
        currentPage = 1;
        applyFilters();
        if (sortDropdown) sortDropdown.classList.remove("active");
    });
});

if (sortDropdown) {
    sortDropdown.addEventListener("change", function () {
        currentSort = this.value;
        currentPage = 1;
        applyFilters();
    });
}

document.addEventListener("click", function (e) {
    if (sortDropdown && !sortDropdown.contains(e.target)) {
        sortDropdown.classList.remove("active");
    }
});

/*=========================================================
                GRID VIEW
=========================================================*/

if (gridViewBtn) {
    gridViewBtn.addEventListener("click", function () {
        currentView = "grid";
        gridViewBtn.classList.add("active");
        if (listViewBtn) listViewBtn.classList.remove("active");
        renderProducts();
    });
}

/*=========================================================
                LIST VIEW
=========================================================*/

if (listViewBtn) {
    listViewBtn.addEventListener("click", function () {
        currentView = "list";
        listViewBtn.classList.add("active");
        if (gridViewBtn) gridViewBtn.classList.remove("active");
        renderProducts();
    });
}

/*=========================================================
                    FORMAT PRICE
=========================================================*/

function getPrice(price) {
    if (price === undefined || price === null) return 0;
    return Number(String(price).replace(/,/g, "").replace(/[^\d.]/g, "")) || 0;
}

function formatPrice(price) {

    if (price === undefined || price === null || price === "")
        return "-";

    const value = Number(price);

    if (isNaN(value))
        return "-";

    return value.toLocaleString("en-IN");

}

/*=========================================================
                    APPLY FILTERS
=========================================================*/

function applyFilters() {
    filteredProducts = [...products];

    /*-----------------------------
            CATEGORY FILTER
    ------------------------------*/

    if (currentCategory !== "all") {
        filteredProducts = filteredProducts.filter(product => {
            const catName = typeof product.category === "string"
                ? product.category.toLowerCase()
                : (product.category?.name?.toLowerCase() || "");
            return catName === currentCategory.toLowerCase();
        });
    }

    /*-----------------------------
                SEARCH
    ------------------------------*/

    if (currentSearch !== "") {
        filteredProducts = filteredProducts.filter(product => product.name.toLowerCase().includes(currentSearch));
    }

    /*-----------------------------
                SORTING
    ------------------------------*/

    const getProductMinPrice = (prod) => {
        if (prod.price !== undefined && prod.price !== null && prod.price !== "" && prod.price !== 0) {
            return getPrice(prod.price);
        }
        if (!prod.sizes || prod.sizes.length === 0) return 0;
        const prices = prod.sizes.map(s => getPrice(s.price));
        return Math.min(...prices);
    };

    switch (currentSort) {
        case "low":
            filteredProducts.sort((a, b) => getProductMinPrice(a) - getProductMinPrice(b));
            break;
        case "high":
            filteredProducts.sort((a, b) => getProductMinPrice(b) - getProductMinPrice(a));
            break;
        case "az":
            filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case "za":
            filteredProducts.sort((a, b) => b.name.localeCompare(a.name));
            break;
        default:
            break;
    }

    updateResultCount();
    renderProducts();
    renderPagination();
}

/*=========================================================
                RENDER PRODUCTS
=========================================================*/

function renderProducts() {
    if (!productsGrid) return;

    productsGrid.innerHTML = "";

    if (filteredProducts.length === 0) {
        if (noProducts) noProducts.style.display = "block";
        productsGrid.style.display = "none";
        if (pagination) pagination.style.display = "none";
        return;
    }

    if (noProducts) noProducts.style.display = "none";
    productsGrid.style.display = "";
    if (pagination) pagination.style.display = "flex";

    const start = (currentPage - 1) * productsPerPage;
    const end = start + productsPerPage;
    const pageProducts = filteredProducts.slice(start, end);

    pageProducts.forEach(product => {

        /*==========================
        PRICE
        ==========================*/

        let displayPrice = "-";

        const categoryNameCheck = typeof product.category === "string"
            ? product.category.toLowerCase()
            : (product.category?.name?.toLowerCase() || "");

        if (categoryNameCheck === "planters") {

            // Always show price range for Planters
            if (product.sizes && typeof product.sizes === "object") {

                const sizeValues = Array.isArray(product.sizes)
                    ? product.sizes
                    : Object.values(product.sizes);

                const prices = sizeValues
                    .map(s => getPrice(s.price))
                    .filter(p => p > 0);

                if (prices.length) {
                    displayPrice = `${formatPrice(Math.min(...prices))} - ${formatPrice(Math.max(...prices))}`;
                }

            } else if (product.min_price && product.max_price) {

                displayPrice = `${formatPrice(product.min_price)} - ${formatPrice(product.max_price)}`;

            } else if (product.price) {

                displayPrice = formatPrice(product.price);

            }

        } else {

            // Existing logic for all other categories
            if (product.price !== undefined && product.price !== null && product.price !== "" && product.price !== 0) {

                displayPrice = formatPrice(product.price);

            } else if (product.sizes && typeof product.sizes === "object") {

                const sizeValues = Array.isArray(product.sizes)
                    ? product.sizes
                    : Object.values(product.sizes);

                const prices = sizeValues
                    .map(s => getPrice(s.price))
                    .filter(p => p > 0);

                if (prices.length) {
                    const minPrice = Math.min(...prices);
                    const maxPrice = Math.max(...prices);

                    displayPrice = minPrice === maxPrice
                        ? formatPrice(minPrice)
                        : `${formatPrice(minPrice)} - ${formatPrice(maxPrice)}`;
                }

            }

        }

        // Append " + Sq. Ft" if category contains GRC
        if (categoryNameCheck.includes("grc") && displayPrice !== "-") {
            displayPrice += " + Sq. Ft";
        }

        /*==========================
        SIZE
        ==========================*/

        let displaySizes = "-";

        if (typeof product.size === "string" && product.size !== "") {

            displaySizes = product.size;

        }
        else if (product.sizes && typeof product.sizes === "object") {

            const sizeValues = Array.isArray(product.sizes) ? product.sizes : Object.values(product.sizes);
            const sizeNames = sizeValues
                .map(s => s.size)
                .filter(Boolean);

            if (sizeNames.length > 0) {
                displaySizes = sizeNames.join(", ");
            }

        }

        /*==========================
        FEATURES
        ==========================*/

        let displayFeatures = "-";
        if (Array.isArray(product.features) && product.features.length > 0) {
            displayFeatures = product.features.join(", ");
        } else if (typeof product.features === "string" && product.features.trim() !== "") {
            displayFeatures = product.features;
        }

        /*==========================
        THUMBNAIL
        ==========================*/

        const thumbnailSrc = (product.thumbnail && product.thumbnail.trim() !== "" && product.thumbnail !== "-")
            ? product.thumbnail
            : "assets/images/placeholder.jpg";

        const categoryName = typeof product.category === "string"
            ? product.category
            : (product.category?.name || "-");

        /*=================================================
                            GRID VIEW
        =================================================*/

        if (currentView === "grid") {
            productsGrid.innerHTML += `
                <div class="product-card">
                    <div class="product-image">
                        <img src="${thumbnailSrc}" alt="${product.name || "-"}" loading="lazy">
                        <span class="product-category">${categoryName}</span>
                    </div>
                    <div class="product-content">
                        <h3 title="${product.name || "-"}">${product.name || "-"}</h3>
                        <div class="product-price">₹ ${displayPrice}</div>
                        <a href="product-details.php?id=${product.id}&slug=${product.slug}" class="btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            `;
        }

        /*=================================================
                            LIST VIEW
        =================================================*/

        else {
            productsGrid.innerHTML += `
                <div class="product-list-card">
                    <div class="list-image">
                        <img src="${thumbnailSrc}" alt="${product.name || "-"}" loading="lazy">
                        <span class="list-category">${categoryName}</span>                  
                        <div class="list-price">₹ ${displayPrice}</div>
                        <a href="product-details.php?id=${product.id}&slug=${product.slug}" class="btn-primary">
                            View Details
                        </a>
                    </div>
                    <div class="list-details">
                        <h3>${product.name || "-"}</h3>
                        <table class="product-spec-table">
                            <tr>
                                <th>Category</th>
                                <td>${categoryName}</td>
                            </tr>
                            <tr>
                                <th>Material</th>
                                <td>${product.material || "-"}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>${product.color || "-"}</td>
                            </tr>
                            <tr>
                                <th>Sizes</th>
                                <td>${displaySizes}</td>
                            </tr>
                            <tr>
                                <th>Finish</th>
                                <td>${product.finish || "-"}</td>
                            </tr>
                            <tr>
                                <th>Features</th>
                                <td>${displayFeatures}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;
        }
    });

    applyView();
    animateProducts();
    lazyImages();
}

/*=========================================================
                    APPLY VIEW
=========================================================*/

function applyView() {
    if (!productsGrid) return;
    if (currentView === "grid") {
        productsGrid.classList.remove("list-view");
        productsGrid.classList.add("grid-view");
    }
    else {
        productsGrid.classList.remove("grid-view");
        productsGrid.classList.add("list-view");
    }
}

/*=========================================================
                    PRODUCT ANIMATION
=========================================================*/

function animateProducts() {
    const cards = document.querySelectorAll(".product-card, .product-list-card");
    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(30px)";
        setTimeout(() => {
            card.style.transition = ".45s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, index * 70);
    });
}

/*=========================================================
                IMAGE LAZY LOADING
=========================================================*/

function lazyImages() {
    const images = document.querySelectorAll("img[data-src]");
    if (!images.length) return;
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const image = entry.target;
            image.src = image.dataset.src;
            image.removeAttribute("data-src");
            observer.unobserve(image);
        });
    });
    images.forEach(image => observer.observe(image));
}

/*=========================================================
                UPDATE RESULT COUNT
=========================================================*/

function updateResultCount() {
    if (totalCount) totalCount.textContent = filteredProducts.length;
    if (!showingCount) return;

    if (filteredProducts.length === 0) {
        showingCount.textContent = "0";
        return;
    }
    const start = ((currentPage - 1) * productsPerPage) + 1;
    const end = Math.min(currentPage * productsPerPage, filteredProducts.length);
    showingCount.textContent = `${start}-${end}`;
}

/*=========================================================
                RENDER PAGINATION
=========================================================*/

function renderPagination() {
    if (!pagination) return;

    pagination.innerHTML = "";
    const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
    if (totalPages <= 1) {
        return;
    }

    const previousButton = document.createElement("button");
    previousButton.className = "page-btn";
    previousButton.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
    previousButton.disabled = currentPage === 1;
    previousButton.addEventListener("click", () => {
        currentPage--;
        renderProducts();
        updateResultCount();
        renderPagination();
        scrollToProducts();
    });
    pagination.appendChild(previousButton);

    for (let page = 1; page <= totalPages; page++) {
        const button = document.createElement("button");
        button.className = "page-btn";
        button.textContent = page;
        if (page === currentPage) {
            button.classList.add("active");
        }
        button.addEventListener("click", () => {
            currentPage = page;
            renderProducts();
            updateResultCount();
            renderPagination();
            scrollToProducts();
        });
        pagination.appendChild(button);
    }

    const nextButton = document.createElement("button");
    nextButton.className = "page-btn";
    nextButton.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
    nextButton.disabled = currentPage === totalPages;
    nextButton.addEventListener("click", () => {
        currentPage++;
        renderProducts();
        updateResultCount();
        renderPagination();
        scrollToProducts();
    });
    pagination.appendChild(nextButton);
}

/*=========================================================
                SCROLL TO PRODUCTS
=========================================================*/

function scrollToProducts() {
    if (productsGrid) {
        productsGrid.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    }
}

/*=========================================================
                RESET FILTERS
=========================================================*/

function resetFilters() {
    currentCategory = "all";
    currentSearch = "";
    currentSort = "default";
    currentView = "grid";
    currentPage = 1;
    if (searchInput) {
        searchInput.value = "";
    }
    if (sortDropdown) {
        sortDropdown.value = "default";
    }
    categoryButtons.forEach(button => {
        button.classList.remove("active");
    });
    if (categoryButtons.length > 0) {
        categoryButtons[0].classList.add("active");
    }
    if (gridViewBtn) gridViewBtn.classList.add("active");
    if (listViewBtn) listViewBtn.classList.remove("active");

    applyFilters();
}

/*=========================================================
                RESET BUTTON
=========================================================*/

const resetButton = document.getElementById("resetProducts");
if (resetButton) {
    resetButton.addEventListener("click", resetFilters);
}

/*=========================================================
                WINDOW LOAD
=========================================================*/

window.addEventListener("load", () => {
    loadProducts();
});

/*=========================================================
                    END
=========================================================*/