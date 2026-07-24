/*=========================================
        PRODUCT DETAILS
=========================================*/

const loader = document.getElementById("loader");

function showLoader() {
    loader.classList.add("active");
    document.body.classList.add('loading');
}

function hideLoader() {
    loader.classList.remove("active");
    document.body.classList.remove('loading');
}

const productContainer = document.getElementById("productDetails");
const relatedProducts = document.getElementById("relatedProducts");

let allProducts = [];

/*=========================================
        GET SLUG
=========================================*/

const params = new URLSearchParams(window.location.search);
const slug = params.get("slug");

/*=========================================
        LOAD PRODUCT
=========================================*/

async function loadProduct() {

    showLoader();
    try {

        /* Product */

        const response = await fetch(
            `api/product.php?slug=${encodeURIComponent(slug)}`
        );

        const data = await response.json();

        if (!data.success) {

            productContainer.innerHTML = `
                <div class="product-not-found">
                    <h2>Product Not Found</h2>
                    <a href="products.php" class="btn-primary">
                        Back to Products
                    </a>
                </div>
            `;

            return;
        }

        /* All Products */

        const productsResponse = await fetch("api/products.php");
        const productsData = await productsResponse.json();

        allProducts = productsData.products || [];

        renderProduct(data.product);

        renderRelatedProducts(data.product);

    }
    catch (error) {

        console.error("Unable to load product.", error);

    }
    finally {
        hideLoader();
    }

}

/*=========================================
        FORMAT PRICE
=========================================*/

function formatPrice(price) {

    if (
        price === undefined ||
        price === null ||
        price === "" ||
        Number(price) === 0
    ) {
        return "-";
    }

    return Number(price).toLocaleString("en-IN");

}

/*=========================================
        DISPLAY PRICE
=========================================*/

function getProductDisplayPrice(product) {

    /* Multiple Sizes - Default to 1st size price if available */

    if (
        product.sizes &&
        product.sizes.length > 0
    ) {
        return formatPrice(product.sizes[0].price);
    }

    /* Single Size */

    if (
        product.size &&
        Number(product.size.price) > 0
    ) {
        return formatPrice(product.size.price);
    }

    /* Flat Price */

    if (
        product.price &&
        Number(product.price) > 0
    ) {
        return formatPrice(product.price);
    }

    return "-";

}

/*=========================================
        DIMENSION ROWS
=========================================*/

function generateDimensionRows(size) {

    if (!size) {

        return `
            <tr>
                <th>Size</th>
                <td>-</td>
            </tr>
        `;

    }

    const lengthMm = size.dimensions?.length?.mm ?? size.length_mm;
    const lengthInch = size.dimensions?.length?.inch ?? size.length_inch;

    const breadthMm = size.dimensions?.breadth?.mm ?? size.breadth_mm;
    const breadthInch = size.dimensions?.breadth?.inch ?? size.breadth_inch;

    const heightMm = size.dimensions?.height?.mm ?? size.height_mm;
    const heightInch = size.dimensions?.height?.inch ?? size.height_inch;

    const formatDimension = (mm, inch) => {
        const parts = [];
        if (mm !== undefined && mm !== null && mm !== "") parts.push(`${mm} mm`);
        if (inch !== undefined && inch !== null && inch !== "") parts.push(`${inch} inch`);
        return parts.length > 0 ? parts.join(" / ") : "-";
    };

    return `

        <tr>
            <th>Size</th>
            <td>${size.size || size.name || "-"}</td>
        </tr>

        <tr>
            <th>Length</th>
            <td>${formatDimension(lengthMm, lengthInch)}</td>
        </tr>

        <tr>
            <th>Breadth</th>
            <td>${formatDimension(breadthMm, breadthInch)}</td>
        </tr>

        <tr>
            <th>Height</th>
            <td>${formatDimension(heightMm, heightInch)}</td>
        </tr>

    `;

}

/*=========================================
        GENERATE SPECIFICATION ROWS
=========================================*/

function generateSpecificationRows(product, selectedSize = null) {

    // If multiple sizes exist and none explicitly passed, default to the 1st size
    const size = selectedSize || (product.sizes && product.sizes.length > 0 ? product.sizes[0] : (product.size || {}));

    const featuresHTML = (product.features || [])
        .map(feature => `<li>${feature}</li>`)
        .join("");

    return `
        <tr>
            <th>Material</th>
            <td>${product.material || "-"}</td>
        </tr>
        <tr>
            <th>Shape</th>
            <td>${product.shape || "-"}</td>
        </tr>
        <tr>
            <th>Finish</th>
            <td>${product.finish || "-"}</td>
        </tr>
        <tr>
            <th>Color</th>
            <td>${product.color || "-"}</td>
        </tr>
        
        <!-- Output dimension rows directly using formatting logic -->
        ${generateDimensionRows(size)}

        <tr>
            <th>Features</th>
            <td>
                <ul class="ul-dot">
                    ${featuresHTML}
                </ul>
            </td>
        </tr>
        <tr>
            <th>Description</th>
            <td>${product.description || "-"}</td>
        </tr>
    `;
}

/*=========================================
        RENDER PRODUCT
=========================================*/

function renderProduct(product) {

    const displayPrice = getProductDisplayPrice(product);

    /* Category handling supporting both string or object structure */
    const categoryName = typeof product.category === "string"
        ? product.category
        : (product.category?.name || "-");

    /* Resolve Image Path without fallback image */
    const imagePath = product.thumbnail || (product.images && product.images.length > 0 ? product.images[0].image : null);

    const imageHTML = imagePath
        ? `<img src="${imagePath}" alt="${product.name}" id="mainImage">`
        : '';

    /* Variant Selector HTML (if multiple sizes exist) */
    let variantHTML = "";

    let initialQuoteUrl = `contact.php?id=${product.id}&slug=${product.slug}`;

    if (product.sizes && product.sizes.length > 1) {

        initialQuoteUrl += `&size=${encodeURIComponent(product.sizes[0].size)}`;

        variantHTML = `
        <div class="variant-wrapper">

            <label class="variant-title">
                Available Sizes
            </label>

            <div class="variant-buttons">

                ${product.sizes.map((size, index) => `

                    <button
                        type="button"
                        class="variant-btn ${index === 0 ? "active" : ""}"
                        data-index="${index}">

                        ${size.size}

                    </button>

                `).join("")}

            </div>

        </div>
    `;

    }

    /* Render Main Product Layout */
    productContainer.innerHTML = `

        <div class="product-wrapper">

            <div class="product-gallery">
                ${imageHTML}
            </div>

            <div class="product-info">

                <span class="product-category">
                    ${categoryName}
                </span>

                <h1>${product.name}</h1>

                <div class="product-price" id="productPrice">
                    ₹ ${displayPrice}
                </div>

                ${variantHTML}

                <table class="product-specification">
                    <tbody id="specificationBody">
                        ${generateSpecificationRows(product)}
                    </tbody>
                </table>

                <div class="product-buttons">

                    <a
                        href="${initialQuoteUrl}"
                        class="btn-primary quote-btn">

                        Get Quote

                    </a>

                    <a
                        href="products.php"
                        class="btn-outline">

                        Back

                    </a>

                </div>

            </div>

        </div>

    `;

    /*=========================================
        SIZE / VARIANT SWITCHING EVENT LISTENERS
    =========================================*/

    if (product.sizes && product.sizes.length > 1) {

        const buttons = document.querySelectorAll(".variant-btn");

        buttons.forEach(button => {

            button.addEventListener("click", function () {

                buttons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                const index = parseInt(this.dataset.index);
                const selectedSize = product.sizes[index];

                /* Update Price */
                const priceElement = document.getElementById("productPrice");
                if (priceElement) {
                    priceElement.innerHTML = `₹ ${formatPrice(selectedSize.price)}`;
                }

                /* Update Specifications & Dynamic Dimensions */
                const specBody = document.getElementById("specificationBody");
                if (specBody) {
                    specBody.innerHTML = generateSpecificationRows(product, selectedSize);
                }

                /* Update Quote URL with Size Parameter */
                const quoteBtn = document.querySelector(".quote-btn");

                if (quoteBtn) {
                    quoteBtn.href =
                        `contact.php?id=${product.id}` +
                        `&slug=${product.slug}` +
                        `&size=${encodeURIComponent(selectedSize.size)}`;
                }

            });

        });

    }

}

/*=========================================
        RELATED PRODUCTS
=========================================*/

const carousel = document.querySelector(".product-carousel");
const track = document.querySelector(".carousel-track");
const nextBtn = document.querySelector(".next");
const prevBtn = document.querySelector(".prev");

let cards = [];
let currentIndex = 0;
let visibleCards = 4;
let cardWidth = 0;
let autoPlay = null;

/*=========================================
        RENDER RELATED PRODUCTS
=========================================*/

function renderRelatedProducts(currentProduct) {

    if (!relatedProducts) return;

    relatedProducts.innerHTML = "";

    /*----------------------------------
        Current Category
    -----------------------------------*/

    const currentCategoryId =
        currentProduct.category?.id ?? "";

    const currentCategorySlug =
        (currentProduct.category?.slug || "").toLowerCase();

    const currentCategoryName =
        (currentProduct.category?.name || "").toLowerCase();

    /*----------------------------------
        Filter Same Category
    -----------------------------------*/

    const related = allProducts.filter(product => {

        if (Number(product.id) === Number(currentProduct.id)) {
            return false;
        }

        const category = product.category || {};

        return (
            Number(category.id) === Number(currentCategoryId) ||
            (category.slug || "").toLowerCase() === currentCategorySlug ||
            (category.name || "").toLowerCase() === currentCategoryName
        );

    });

    if (!related.length) {

        relatedProducts.innerHTML = `
            <div class="text-center w-100">
                No related products found.
            </div>
        `;

        return;
    }

    /*----------------------------------
        Render
    -----------------------------------*/

    related.forEach(product => {

        const image =
            product.thumbnail ||
            "images/no-image.webp";

        relatedProducts.insertAdjacentHTML("beforeend", `

            <div class="product-card">

                <div class="product-image">

                    <img
                        src="${image}"
                        alt="${product.name}"
                        loading="lazy">

                </div>

                <div class="product-content">

                    <h3>${product.name}</h3>

                    <div class="product-price">
                        ₹ ${getProductDisplayPrice(product)}
                    </div>

                    <a
                        href="product-details.php?id=${product.id}&slug=${product.slug}"
                        class="btn-primary">

                        View Details

                    </a>

                </div>

            </div>

        `);

    });

    cards = [...relatedProducts.querySelectorAll(".product-card")];

    initializeCarousel();

}

/*=========================================
        INITIALIZE CAROUSEL
=========================================*/

function initializeCarousel() {

    currentIndex = 0;

    if (!cards.length)
        return;

    updateVisibleCards();

    if (cards.length <= visibleCards) {

        if (prevBtn) prevBtn.style.display = "none";
        if (nextBtn) nextBtn.style.display = "none";

        stopAutoplay();
        return;

    }

    if (prevBtn) prevBtn.style.display = "flex";
    if (nextBtn) nextBtn.style.display = "flex";

    startAutoplay();

}

/*=========================================
        RESPONSIVE
=========================================*/

function updateVisibleCards() {

    cards = [...relatedProducts.querySelectorAll(".product-card")];
    if (!cards.length) return;

    if (window.innerWidth < 576) {
        visibleCards = 1;
    }
    else if (window.innerWidth < 768) {
        visibleCards = 2;
    }
    else if (window.innerWidth < 992) {
        visibleCards = 3;
    }
    else {
        visibleCards = 4;
    }

    const gap = 25;
    cardWidth = cards[0].getBoundingClientRect().width + gap;

    if (track) {
        track.style.transition = "none";
        track.style.transform = "translateX(0px)";
    }
    currentIndex = 0;

}

/*=========================================
        NEXT SLIDE (SEAMLESS LOOP)
=========================================*/

function nextSlide() {

    cards = [...relatedProducts.querySelectorAll(".product-card")];
    if (cards.length <= visibleCards || !track) return;

    track.style.transition = "transform 0.5s ease";
    track.style.transform = `translateX(-${cardWidth}px)`;

    track.ontransitionend = () => {
        track.style.transition = "none";
        // Move the first card to the very end of the DOM track container
        track.appendChild(track.firstElementChild);
        track.style.transform = "translateX(0px)";
        track.ontransitionend = null; // Clear handler
    };

}

/*=========================================
        PREVIOUS SLIDE (SEAMLESS LOOP)
=========================================*/

function prevSlide() {

    cards = [...relatedProducts.querySelectorAll(".product-card")];
    if (cards.length <= visibleCards || !track) return;

    track.style.transition = "none";
    // Instantly move the last card to the front before sliding visible window back
    track.insertBefore(track.lastElementChild, track.firstElementChild);
    track.style.transform = `translateX(-${cardWidth}px)`;

    setTimeout(() => {
        track.style.transition = "transform 0.5s ease";
        track.style.transform = "translateX(0px)";
    }, 20);

}

/*=========================================
        MOVE CAROUSEL
=========================================*/

/*=========================================
        MOVE CAROUSEL
=========================================*/

function moveCarousel(instant = false) {

    if (!track)
        return;

    if (instant) {
        track.style.transition = "none";
    } else {
        track.style.transition = "transform .5s ease";
    }

    track.style.transform =
        `translateX(-${currentIndex * cardWidth}px)`;

}

/*=========================================
        AUTOPLAY
=========================================*/

function startAutoplay() {

    stopAutoplay();

    if (cards.length <= visibleCards)
        return;

    autoPlay = setInterval(nextSlide, 3000);

}

function stopAutoplay() {

    clearInterval(autoPlay);

}

/*=========================================
        EVENTS
=========================================*/

if (nextBtn)
    nextBtn.addEventListener("click", nextSlide);

if (prevBtn)
    prevBtn.addEventListener("click", prevSlide);

if (carousel) {

    carousel.addEventListener("mouseenter", stopAutoplay);

    carousel.addEventListener("mouseleave", startAutoplay);

}

window.addEventListener("resize", updateVisibleCards);

/*=========================================
        START
=========================================*/

loadProduct();