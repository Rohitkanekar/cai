/*=========================================
        PRODUCT DETAILS
=========================================*/

const productContainer = document.getElementById("productDetails");

/*=========================================
        GET SLUG
=========================================*/

const params = new URLSearchParams(window.location.search);

const slug = params.get("slug");

/*=========================================
        LOAD PRODUCT
=========================================*/

async function loadProduct() {

    try {

        const response = await fetch("data/products.json");

        allProducts = await response.json();

        const product = allProducts.find(item => item.slug === slug);

        if (!product) {

            productContainer.innerHTML = `

                <div class="product-not-found">

                    <h2>Product Not Found</h2>

                    <a href="products.html" class="btn-primary">

                        Back to Products

                    </a>

                </div>

            `;

            return;

        }

        renderProduct(product);

        renderRelatedProducts(product);

    }

    catch (error) {

        console.error(error);

    }

}


/*=========================================
        RENDER PRODUCT
=========================================*/

function renderProduct(product) {

    /*=========================================
            FORMAT FEATURES
    =========================================*/

    const features = Array.isArray(product.features) ? product.features : String(product.features || "").split(",").map(feature => feature.trim()).filter(feature => feature);

    const featuresHTML = features.map(feature => `<li>${feature}</li>`).join("");

    productContainer.innerHTML = `

        <div class="product-wrapper">

            <div class="product-gallery">

                <img
                    src="${product.thumbnail || "-"}"
                    alt="${product.name || "-"}"
                    id="mainImage">

            </div>

            <div class="product-info">

                <span class="product-category">

                    ${product.category || "-"}

                </span>

                <h1>

                    ${product.name || "-"}

                </h1>

                <div class="product-price">

                    ₹ ${formatPrice(product.price)}

                </div>

                <table class="product-specification">

                    <tr>

                        <th>Material</th>

                        <td>${product.material || "-"}</td>

                    </tr>

                    <tr>

                        <th>Color</th>

                        <td>${product.color || "-"}</td>

                    </tr>

                    <tr>

                        <th>Size</th>

                        <td>${product.size || "-"}</td>

                    </tr>

                    <tr>

                        <th>Finish</th>

                        <td>${product.finish || "-"}</td>

                    </tr>

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

                </table>

                <div class="product-buttons">

                    <a href="contact.html" class="btn-primary">

                        Get Quote

                    </a>

                    <a href="products.html" class="btn-outline">

                        Back

                    </a>

                </div>

            </div>

        </div>

`;

}

/*=========================================================
                FORMAT PRICE
=========================================================*/

function formatPrice(price) {

    if (!price) return "-";

    const value = parseFloat(price);

    if (isNaN(value)) {
        return price;
    }

    const suffix = price.replace(/^[\d.,\s]+/, "");

    return `${value.toLocaleString("en-IN")}${suffix}`;
}

/*=========================================
        START
=========================================*/

loadProduct();

/*=========================================
        RELATED PRODUCTS
=========================================*/

const relatedProducts = document.getElementById("relatedProducts");

const carousel = document.querySelector(".product-carousel");

const track = document.querySelector(".carousel-track");

const nextBtn = document.querySelector(".next");

const prevBtn = document.querySelector(".prev");

let cards = [];

let currentIndex = 0;

let visibleCards = 4;

let cardWidth = 0;

let autoPlay;

let allProducts = [];

function renderRelatedProducts(currentProduct) {

    relatedProducts.innerHTML = "";

    currentIndex = 0;

    const related = allProducts.filter(item =>
        item.category === currentProduct.category &&
        item.slug !== currentProduct.slug
    );

    if (!related.length) {

        document.querySelector(".products-more").style.display = "none";

        return;

    }

    related.forEach(product => {

        relatedProducts.insertAdjacentHTML("beforeend", `

            <div class="product-card">

                <div class="product-image">

                    <img src="${product.thumbnail}" alt="${product.name}" loading="lazy">

                </div>

                <div class="product-content">

                    <h3>${product.name}</h3>

                    <div class="product-price">

                        ₹ ${formatPrice(product.price)}

                    </div>

                    <a href="product-details.html?slug=${product.slug}" class="btn-primary">

                        View Details

                    </a>

                </div>

            </div>

        `);

    });

    cards = [...document.querySelectorAll(".product-card")];

    /*=========================================
            LESS THAN 4 PRODUCTS
    =========================================*/

    if (cards.length < 4) {

        stopAutoplay();

        prevBtn.style.display = "none";

        nextBtn.style.display = "none";

        track.style.transform = "none";

        track.style.transition = "none";

        track.classList.add("grid-view");

        return;

    }

    /*=========================================
            CAROUSEL
    =========================================*/

    prevBtn.style.display = "flex";

    prevBtn.style.justifyContent = "center";

    prevBtn.style.alignItems = "center";

    nextBtn.style.display = "flex";

    nextBtn.style.justifyContent = "center";

    nextBtn.style.alignItems = "center";

    track.classList.remove("grid-view");

    updateVisibleCards();

    stopAutoplay();

    startAutoplay();

}


function updateVisibleCards() {

    if (!cards.length) return;

    if (window.innerWidth < 576) {

        visibleCards = 1;

    } else if (window.innerWidth < 768) {

        visibleCards = 2;

    } else if (window.innerWidth < 992) {

        visibleCards = 3;

    } else {

        visibleCards = 4;

    }

    const gap = 25;

    cardWidth = cards[0].getBoundingClientRect().width + gap;

    moveCarousel();

}


function moveCarousel() {

    track.style.transition = "transform .5s ease";

    track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;

}

function nextSlide() {

    if (cards.length < 4) return;

    currentIndex++;

    if (currentIndex > cards.length - visibleCards) {

        currentIndex = 0;

    }

    moveCarousel();

}

function prevSlide() {

    if (cards.length < 4) return;

    currentIndex--;

    if (currentIndex < 0) {

        currentIndex = cards.length - visibleCards;

    }

    moveCarousel();

}

nextBtn.addEventListener("click", nextSlide);

prevBtn.addEventListener("click", prevSlide);

function startAutoplay() {

    if (cards.length < 4) return;

    stopAutoplay();

    autoPlay = setInterval(nextSlide, 3000);

}

function stopAutoplay() {

    clearInterval(autoPlay);

}

if (carousel) {

    carousel.addEventListener("mouseenter", stopAutoplay);

    carousel.addEventListener("mouseleave", startAutoplay);

}

window.addEventListener("resize", updateVisibleCards);