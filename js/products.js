/*=========================================================
                    PRODUCTS PAGE
=========================================================*/

/*=========================================================
                    DOM ELEMENTS
=========================================================*/

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

async function loadProducts(category = "all") {
    try {
        let jsonFile = "data/products.json";
        if (category !== "all") {
            jsonFile = `data/${category}.json`;
        }
        const response = await fetch(jsonFile);
        products = await response.json();
        filteredProducts = [...products];
        currentPage = 1;
        initializeProducts();
    }
    catch (error) {
        console.error("Unable to load products.", error);
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
        loadProducts(currentCategory);
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
sortBtn.addEventListener("click", () => {
    sortDropdown.classList.toggle("active");
});

document.querySelectorAll("#sortMenu li").forEach(item => {
    item.addEventListener("click", function () {
        selectedSort.textContent = this.textContent;
        currentSort = this.dataset.sort;
        currentPage = 1;
        applyFilters();
        sortDropdown.classList.remove("active");
    });
});

sortDropdown.addEventListener("change", function () {
    currentSort = this.value;
    currentPage = 1;
    applyFilters();
});

document.addEventListener("click", function (e) {
    if (!sortDropdown.contains(e.target)) {
        sortDropdown.classList.remove("active");
    }
});

/*=========================================================
                GRID VIEW
=========================================================*/

gridViewBtn.addEventListener("click", function () {
    currentView = "grid";
    gridViewBtn.classList.add("active");
    listViewBtn.classList.remove("active");
    renderProducts();
});

/*=========================================================
                LIST VIEW
=========================================================*/

listViewBtn.addEventListener("click", function () {
    currentView = "list";
    listViewBtn.classList.add("active");
    gridViewBtn.classList.remove("active");
    renderProducts();
});

/*=========================================================
                    FORMAT PRICE (FIXED)
=========================================================*/

function getPrice(price) {
    if (price === undefined || price === null) return 0;
    // Safely convert to a string before running regex replacements
    return Number(String(price).replace(/,/g, "").replace(/[^\d.]/g, "")) || 0;
}

function formatPrice(price) {
    if (price === undefined || price === null) return "-";

    const value = parseFloat(price);
    if (isNaN(value)) {
        return price;
    }

    // Safely pull suffixes only if it was originally a string
    const suffix = typeof price === 'string' ? price.replace(/^[\d.,\s]+/, "") : "";
    return `${value.toLocaleString("en-IN")}${suffix}`;
}

/*=========================================================
                    APPLY FILTERS
=========================================================*/

function applyFilters() {
    filteredProducts = [...products];

    /*-----------------------------
            SEARCH
    ------------------------------*/

    if (currentSearch !== "") {
        filteredProducts = filteredProducts.filter(product => product.name.toLowerCase().includes(currentSearch));
    }

    /*-----------------------------
            SORTING
    ------------------------------*/

    // Helper function inside applyFilters or globally to find a item's baseline price
    /*-----------------------------
        SORTING MATCHING BOTH STRATEGIES
------------------------------*/

    const getProductMinPrice = (prod) => {
        // If it has a standard top level price, use that
        if (prod.price !== undefined && prod.price !== null) {
            return getPrice(prod.price);
        }
        // Otherwise fallback to checking sizes
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

/*=========================================================
                RENDER PRODUCTS (FIXED)
=========================================================*/

/*=========================================================
                RENDER PRODUCTS (ALL CATEGORIES)
=========================================================*/

function renderProducts() {
    productsGrid.innerHTML = "";
    if (filteredProducts.length === 0) {
        noProducts.style.display = "block";
        productsGrid.style.display = "none";
        pagination.style.display = "none";
        return;
    }
    noProducts.style.display = "none";
    productsGrid.style.display = "";
    pagination.style.display = "flex";

    const start = (currentPage - 1) * productsPerPage;
    const end = start + productsPerPage;
    const pageProducts = filteredProducts.slice(start, end);

    pageProducts.forEach(product => {

        // --- MULTI-CATEGORY PRICE STRATEGY ---
        let displayPrice = "-";

        if (product.price !== undefined && product.price !== null) {
            // Case 1: Standard flat price (Benches / Statues without variants)
            displayPrice = formatPrice(product.price);
        } else if (product.sizes && product.sizes.length > 0) {
            // Case 2: Nested sizes array (Planters / GRC / Size variants)
            const prices = product.sizes.map(s => Number(s.price)).filter(p => !isNaN(p));
            if (prices.length > 0) {
                const minPrice = Math.min(...prices);
                const maxPrice = Math.max(...prices);

                if (minPrice === maxPrice) {
                    displayPrice = formatPrice(minPrice);
                } else {
                    displayPrice = `${formatPrice(minPrice)} - ${formatPrice(maxPrice)}`;
                }
            }
        }

        // Gather sizes string for the list view table
        let displaySizes = "-";
        if (product.size) {
            displaySizes = product.size;
        } else if (product.sizes && product.sizes.length > 0) {
            displaySizes = product.sizes.map(s => s.size).join(", ");
        }

        /*=================================================
                        GRID VIEW
        =================================================*/

        if (currentView === "grid") {
            productsGrid.innerHTML += `
                <div class="product-card">
                    <div class="product-image">
                        <img src="${product.thumbnail || "-"}" alt="${product.name || "-"}" loading="lazy">
                        <span class="product-category">${product.category || "-"}</span>
                    </div>
                    <div class="product-content">
                        <h3 title="${product.name || "-"}">${product.name || "-"}</h3>
                        <div class="product-price">₹ ${displayPrice}</div>
                        <a href="product-details.html?id=${product.id}&slug=${product.slug}" class="btn-primary">
                            View Details <i class="fa-solid fa-chevron-right"></i>
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
                        <img src="${product.thumbnail || "-"}" alt="${product.name || "-"}" loading="lazy">
                        <span class="list-category">${product.category || "-"}</span>                        
                        <div class="list-price">₹ ${displayPrice}</div>
                        <a href="product-details.html?id=${product.id}&slug=${product.slug}" class="btn-primary">
                            View Details
                        </a>
                    </div>
                    <div class="list-details">
                        <h3>${product.name || "-"}</h3>
                        <table class="product-spec-table">
                            <tr>
                                <th>Category</th>
                                <td>${product.category || "-"}</td>
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
                                <td>${product.features || "-"}</td>
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
    totalCount.textContent = filteredProducts.length;
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
    pagination.innerHTML = "";
    const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
    if (totalPages <= 1) {
        return;
    }

    /*=========================
            PREVIOUS
    =========================*/

    const previousButton = document.createElement("button");
    previousButton.className = "page-btn";
    previousButton.innerHTML = "&laquo;";
    previousButton.disabled = currentPage === 1;
    previousButton.addEventListener("click", () => {
        currentPage--;
        renderProducts();
        updateResultCount();
        renderPagination();
        scrollToProducts();
    });
    pagination.appendChild(previousButton);

    /*=========================
            PAGE NUMBERS
    =========================*/

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

    /*=========================
            NEXT
    =========================*/

    const nextButton = document.createElement("button");
    nextButton.className = "page-btn";
    nextButton.innerHTML = "&raquo;";
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
    productsGrid.scrollIntoView({
        behavior: "smooth",
        block: "start"
    });
}

/*=========================================================
                CHECK PRODUCTS
=========================================================*/

function checkProducts() {
    if (filteredProducts.length === 0) {
        noProducts.style.display = "block";
        productsGrid.style.display = "none";
        pagination.style.display = "none";
    }
    else {
        noProducts.style.display = "none";
        productsGrid.style.display = "";
        pagination.style.display = "flex";
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
    sortDropdown.value = "default";
    categoryButtons.forEach(button => {
        button.classList.remove("active");
    });
    categoryButtons[0].classList.add("active");
    gridViewBtn.classList.add("active");
    listViewBtn.classList.remove("active");
    loadProducts("all");
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
    loadProducts("all");
});

/*=========================================================
                END
=========================================================*/