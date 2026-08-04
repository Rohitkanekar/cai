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

function getProductDisplayPrice(product, selectedSize = null) {

    let rawPrice = "-";

    const size = selectedSize || (product.sizes && product.sizes.length > 0 ? product.sizes[0] : (product.size || {}));

    /* Selected Size or 1st Size Price */
    if (size && size.price !== undefined && size.price !== null && size.price !== "") {
        rawPrice = formatPrice(size.price);
    }
    /* Flat Price */
    else if (
        product.price &&
        Number(product.price) > 0
    ) {
        rawPrice = formatPrice(product.price);
    }

    if (rawPrice === "-") {
        return "-";
    }

    /* Check category for GRC */
    const categoryObj = product.category;
    let categoryNameCheck = "";
    if (typeof categoryObj === "string") {
        categoryNameCheck = categoryObj.toLowerCase();
    } else if (categoryObj && typeof categoryObj === "object") {
        categoryNameCheck = (categoryObj.slug || categoryObj.name || "").toLowerCase();
    }

    if (categoryNameCheck.includes("grc")) {
        return `${rawPrice} + Sq. Ft`;
    }

    return rawPrice;

}

/*=========================================
        RELATED PRODUCTS PRICE RANGE
=========================================*/

function getRelatedProductPriceRange(product) {
    /* Check category for GRC */
    const categoryObj = product.category;
    let categoryNameCheck = "";
    if (typeof categoryObj === "string") {
        categoryNameCheck = categoryObj.toLowerCase();
    } else if (categoryObj && typeof categoryObj === "object") {
        categoryNameCheck = (categoryObj.slug || categoryObj.name || "").toLowerCase();
    }

    const isPlanter = categoryNameCheck.includes("planter");

    // If it's a planter with multiple sizes, calculate and return a price range (Min - Max)
    if (isPlanter && product.sizes && product.sizes.length > 0) {
        const prices = product.sizes
            .map(s => Number(s.price))
            .filter(p => !isNaN(p) && p > 0);

        if (prices.length > 0) {
            const minPrice = Math.min(...prices);
            const maxPrice = Math.max(...prices);

            let priceOutput = "";
            if (minPrice === maxPrice) {
                priceOutput = formatPrice(minPrice);
            } else {
                priceOutput = `${formatPrice(minPrice)} - ${formatPrice(maxPrice)}`;
            }

            if (categoryNameCheck.includes("grc") && priceOutput !== "-") {
                priceOutput += " + Sq. Ft";
            }

            return priceOutput;
        }
    }

    // Fallback to regular single/default display price if not a multi-size planter
    return getProductDisplayPrice(product);
}

/*=========================================
        DIMENSION ROWS
=========================================*/

function generateDimensionRows(size, categoryName = "") {

    if (!size) {

        return `
            <tr>
                <th>Size</th>
                <td>-</td>
            </tr>
        `;

    }

    // Check if the product is a planter based on category name
    const isPlanter = categoryName.toLowerCase().includes('planter');

    // If it's NOT a planter, hide length, breadth, and height entirely
    if (!isPlanter) {
        const sizeValue = (size.size !== undefined && size.size !== null && size.size !== "") ? size.size : ((size.name !== undefined && size.name !== null && size.name !== "") ? size.name : "-");
        return `
            <tr>
                <th>Size</th>
                <td>${sizeValue}</td>
            </tr>
        `;
    }

    // --- For Planters: Show full dimensions ---
    const lengthMm = size.dimensions?.length?.mm ?? size.length_mm;
    const lengthInch = size.dimensions?.length?.inch ?? size.length_inch;

    const breadthMm = size.dimensions?.breadth?.mm ?? size.breadth_mm ?? size.breadth_MM;
    const breadthInch = size.dimensions?.breadth?.inch ?? size.breadth_inch ?? size.breadth_Inch;

    const heightMm = size.dimensions?.height?.mm ?? size.height_mm;
    const heightInch = size.dimensions?.height?.inch ?? size.height_inch;

    const formatDimension = (mm, inch) => {
        const parts = [];
        if (mm !== undefined && mm !== null && mm !== "") parts.push(`${mm} Mm`);
        if (inch !== undefined && inch !== null && inch !== "") parts.push(`${inch} Inch`);
        return parts.length > 0 ? parts.join(" / ") : "-";
    };

    const sizeValue = (size.size !== undefined && size.size !== null && size.size !== "") ? size.size : ((size.name !== undefined && size.name !== null && size.name !== "") ? size.name : "-");

    return `
        <tr>
            <th>Size</th>
            <td>${sizeValue}</td>
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

    /* Category handling supporting both string or object structure */
    const categoryName = typeof product.category === "string"
        ? product.category
        : (product.category?.name || "-");

    const materialVal = (product.material !== undefined && product.material !== null && product.material !== "") ? product.material : "-";
    const shapeVal = (product.shape !== undefined && product.shape !== null && product.shape !== "") ? product.shape : "-";
    const finishVal = (product.finish !== undefined && product.finish !== null && product.finish !== "") ? product.finish : "-";
    const colorVal = (product.color !== undefined && product.color !== null && product.color !== "") ? product.color : "-";
    const descriptionVal = (product.description !== undefined && product.description !== null && product.description !== "") ? product.description : "-";

    // Check if features exist and are not empty
    const hasFeatures = product.features && Array.isArray(product.features) && product.features.length > 0 && product.features.some(f => f && f.trim() !== "");

    const featuresHTML = hasFeatures
        ? `<ul class="ul-dot">${product.features.map(feature => `<li>${feature}</li>`).join("")}</ul>`
        : "-";

    return `
        <tr>
            <th>Material</th>
            <td>${materialVal}</td>
        </tr>
        <tr>
            <th>Shape</th>
            <td>${shapeVal}</td>
        </tr>
        <tr>
            <th>Finish</th>
            <td>${finishVal}</td>
        </tr>
        <tr>
            <th>Color</th>
            <td>${colorVal}</td>
        </tr>
        
        <!-- Output dimension rows conditionally based on whether it's a planter -->
        ${generateDimensionRows(size, categoryName)}

        <tr>
            <th>Features</th>
            <td>${featuresHTML}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>${descriptionVal}</td>
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

    /* Resolve Image Path with fallback */
    const imagePath = (product.thumbnail && product.thumbnail.trim() !== "" && product.thumbnail !== "-")
        ? product.thumbnail
        : (product.images && product.images.length > 0 ? product.images[0].image : "assets/images/placeholder.jpg");

    const imageHTML = imagePath
        ? `<img src="${imagePath}" alt="${product.name}" id="mainImage">`
        : '';

    /* Variant Selector HTML (if multiple sizes exist) */
    let variantHTML = "";

    const defaultSize = product.sizes && product.sizes.length > 0 ? product.sizes[0] : (product.size || {});
    const defaultLengthMm = defaultSize.dimensions?.length?.mm ?? defaultSize.length_mm ?? "";
    const defaultBreadthMm = defaultSize.dimensions?.breadth?.mm ?? defaultSize.breadth_mm ?? defaultSize.breadth_MM ?? "";
    const defaultHeightMm = defaultSize.dimensions?.height?.mm ?? defaultSize.height_mm ?? "";
    const defaultSizeValue = defaultSize.size || defaultSize.name || "";
    const defaultPriceValue = defaultSize.price || product.price || "";

    let initialQuoteUrl = `contact.php?id=${encodeURIComponent(product.id || '')}` +
        `&slug=${encodeURIComponent(product.slug || '')}` +
        `&productName=${encodeURIComponent(product.name || '')}` +
        `&productCategory=${encodeURIComponent(categoryName)}` +
        `&productMaterial=${encodeURIComponent(product.material || '')}` +
        `&productSize=${encodeURIComponent(defaultSizeValue)}` +
        `&productPrice=${encodeURIComponent(defaultPriceValue)}` +
        `&productLength=${encodeURIComponent(defaultLengthMm)}` +
        `&productBreadth=${encodeURIComponent(defaultBreadthMm)}` +
        `&productHeight=${encodeURIComponent(defaultHeightMm)}` +
        `&productColor=${encodeURIComponent(product.color || '')}` +
        `&productFinish=${encodeURIComponent(product.finish || '')}` +
        `&productImage=${encodeURIComponent(imagePath)}` +
        `&productURL=${encodeURIComponent(window.location.href)}`;

    if (product.features && Array.isArray(product.features)) {
        product.features.forEach((feature, idx) => {
            initialQuoteUrl += `&productFeatures[${idx}]=${encodeURIComponent(feature)}`;
        });
    }

    if (product.sizes && product.sizes.length > 1) {

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

    const buttons = document.querySelectorAll(".variant-btn");

    if (buttons.length > 0) {

        buttons.forEach(button => {

            button.addEventListener("click", function () {

                buttons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                const index = parseInt(this.dataset.index);
                const selectedSize = product.sizes[index];

                /* Update Price */
                const priceElement = document.getElementById("productPrice");
                if (priceElement) {
                    let variantPrice = formatPrice(selectedSize.price);

                    const categoryObj = product.category;
                    let categoryNameCheck = "";
                    if (typeof categoryObj === "string") {
                        categoryNameCheck = categoryObj.toLowerCase();
                    } else if (categoryObj && typeof categoryObj === "object") {
                        categoryNameCheck = (categoryObj.slug || categoryObj.name || "").toLowerCase();
                    }

                    if (categoryNameCheck.includes("grc") && variantPrice !== "-") {
                        variantPrice += " + Sq. Ft";
                    }

                    priceElement.innerHTML = `₹ ${variantPrice}`;
                }

                /* Update Specifications & Dynamic Dimensions */
                const specBody = document.getElementById("specificationBody");
                if (specBody) {
                    specBody.innerHTML = generateSpecificationRows(product, selectedSize);
                }

                /* Update Quote URL with Size Parameter */
                const quoteBtn = document.querySelector(".quote-btn");

                if (quoteBtn) {
                    const selLengthMm = selectedSize.dimensions?.length?.mm ?? selectedSize.length_mm ?? "";
                    const selBreadthMm = selectedSize.dimensions?.breadth?.mm ?? selectedSize.breadth_mm ?? selectedSize.breadth_MM ?? "";
                    const selHeightMm = selectedSize.dimensions?.height?.mm ?? selectedSize.height_mm ?? "";
                    const selSizeValue = selectedSize.size || selectedSize.name || "";
                    const selPriceValue = selectedSize.price || product.price || "";

                    let updatedUrl = `contact.php?id=${encodeURIComponent(product.id || '')}` +
                        `&slug=${encodeURIComponent(product.slug || '')}` +
                        `&productName=${encodeURIComponent(product.name || '')}` +
                        `&productCategory=${encodeURIComponent(categoryName)}` +
                        `&productMaterial=${encodeURIComponent(product.material || '')}` +
                        `&productSize=${encodeURIComponent(selSizeValue)}` +
                        `&productPrice=${encodeURIComponent(selPriceValue)}` +
                        `&productLength=${encodeURIComponent(selLengthMm)}` +
                        `&productBreadth=${encodeURIComponent(selBreadthMm)}` +
                        `&productHeight=${encodeURIComponent(selHeightMm)}` +
                        `&productColor=${encodeURIComponent(product.color || '')}` +
                        `&productFinish=${encodeURIComponent(product.finish || '')}` +
                        `&productImage=${encodeURIComponent(imagePath)}` +
                        `&productURL=${encodeURIComponent(window.location.href)}`;

                    if (product.features && Array.isArray(product.features)) {
                        product.features.forEach((feature, idx) => {
                            updatedUrl += `&productFeatures[${idx}]=${encodeURIComponent(feature)}`;
                        });
                    }

                    quoteBtn.href = updatedUrl;
                }

            });

        });

    }

    console.log('Current Product', product);

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

        const cardPriceRange = getRelatedProductPriceRange(product);

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
                        ₹ ${cardPriceRange}
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
        track.appendChild(track.firstElementChild);
        track.style.transform = "translateX(0px)";
        track.ontransitionend = null;
    };

}

/*=========================================
        PREVIOUS SLIDE (SEAMLESS LOOP)
=========================================*/

function prevSlide() {

    cards = [...relatedProducts.querySelectorAll(".product-card")];
    if (cards.length <= visibleCards || !track) return;

    track.style.transition = "none";
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