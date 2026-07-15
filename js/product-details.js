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
        DETERMINE DYNAMIC PRICE
=========================================*/

function getProductDisplayPrice(product) {
    if (product.price !== undefined && product.price !== null) {
        return formatPrice(product.price);
    } else if (product.sizes && product.sizes.length > 0) {
        const prices = product.sizes.map(s => Number(s.price)).filter(p => !isNaN(p));
        if (prices.length > 0) {
            const minPrice = Math.min(...prices);
            const maxPrice = Math.max(...prices);
            
            if (minPrice === maxPrice) {
                return formatPrice(minPrice);
            } else {
                return `${formatPrice(minPrice)} - ${formatPrice(maxPrice)}`;
            }
        }
    }
    return "-";
}

/*=========================================
       FORMAT NESTED DIMENSIONS
=========================================*/

function formatDimensions(dims) {
    if (!dims || typeof dims !== 'object') return null;
    
    const l = dims.length || {};
    const h = dims.height || {};
    const b = dims.breadth || {};
    
    // Check if we have standard L x B x H values
    if (l.mm || h.mm || b.mm) {
        const mmStr = `${l.mm || 0} x ${b.mm || 0} x ${h.mm || 0} mm`;
        const inchStr = (l.inch || h.inch || b.inch) ? ` (${l.inch || 0} x ${b.inch || 0} x ${h.inch || 0} inch)` : '';
        return `${mmStr}${inchStr}`;
    }
    
    return null;
}

/*=========================================
     GENERATE LABELED DIMENSION ROWS
=========================================*/

function generateDimensionRows(sizeString) {
    if (!sizeString || sizeString === "-") {
        return `<tr><th>Size / Dimensions</th><td>-</td></tr>`;
    }

    const regex = /^([\d.]+)\s*x\s*([\d.]+)\s*x\s*([\d.]+)\s*mm(?:\s*\(\s*([\d.]+)\s*x\s*([\d.]+)\s*x\s*([\d.]+)\s*inch\s*\))?$/i;
    const match = sizeString.match(regex);

    if (match) {
        const l_mm = match[1];
        const b_mm = match[2];
        const h_mm = match[3];
        const l_in = match[4];
        const b_in = match[5];
        const h_in = match[6];

        const l_display = l_in ? `${l_mm} mm (${l_in} inch)` : `${l_mm} mm`;
        const b_display = b_in ? `${b_mm} mm (${b_in} inch)` : `${b_mm} mm`;
        const h_display = h_in ? `${h_mm} mm (${h_in} inch)` : `${h_mm} mm`;

        return `
            <tr><th>Length</th><td>${l_display}</td></tr>
            <tr><th>Breadth</th><td>${b_display}</td></tr>
            <tr><th>Height</th><td>${h_display}</td></tr>
        `;
    }

    return `<tr><th>Size / Dimensions</th><td>${sizeString}</td></tr>`;
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
    
    // Dynamic Base/Range Price Setup
    const displayPrice = getProductDisplayPrice(product);

    // --- SMART IMAGE CHECK ---
    // Evaluates key name fallbacks if your JSON properties differ across collections
    const productImageSrc = product.thumbnail || product.image || product.img || "";

    // --- HYBRID EXTRACTION: HOLDS BOTH APPROACHES SIMULTANEOUSLY ---
    let initialSize = "-";
    let initialWeight = "-";

    const topLevelDims = formatDimensions(product.dimensions);
    if (topLevelDims) {
        initialSize = topLevelDims;
    } else if (product.size) {
        initialSize = product.size;
    } else if (product.sizes && product.sizes.length > 0) {
        const firstVariant = product.sizes[0];
        const variantDims = formatDimensions(firstVariant.dimensions);
        initialSize = variantDims ? variantDims : (firstVariant.size || "-");
    }    

    let variantSelectorHTML = "";
    
    let specificationsHTML = `
        <tr>
            <th>Material</th>
            <td>${product.material || "-"}</td>
        </tr>
        <tr>
            <th>Color</th>
            <td>${product.color || "-"}</td>
        </tr>
        <tbody id="dynamicDimensionRows">
            ${generateDimensionRows(initialSize)}
        </tbody>
        <tr id="detailWeightRow">
            <th>Weight</th>
            <td id="detailWeight">${product.weight || "-"}</td>
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
    `;

    // --- UL / LI VARIANT SELECTION (COMBINED APPROACHES) ---
    if (product.sizes && product.sizes.length > 0) {
        const listItemsHTML = product.sizes.map((s, idx) => {
            let buttonLabel = s.size;
            if (!buttonLabel || buttonLabel.trim() === "" || buttonLabel === "-") {
                const computedDims = formatDimensions(s.dimensions);
                buttonLabel = computedDims ? computedDims.split(" (")[0] : `Option ${idx + 1}`; 
            }
            
            return `
                <li class="variant-item${idx === 0 ? ' active' : ''}" data-index="${idx}">
                    ${buttonLabel}
                </li>
            `;
        }).join("");

        variantSelectorHTML = `
            <div class="variant-selector">
                <label>Select Variant:</label>
                <ul id="sizeList">
                    ${listItemsHTML}
                </ul>
            </div>
        `;
    }

    // Fixed the image element template literal setup below
    productContainer.innerHTML = `
        <div class="product-wrapper">
            <div class="product-gallery">
                <img src="${productImageSrc}" alt="${product.name || "Product Image"}" id="mainImage">
            </div>
            <div class="product-info">
                <span class="product-category">${product.category || "-"}</span>
                <h1>${product.name || "-"}</h1>
                
                <div class="product-price" id="dynamicPrice">₹ ${displayPrice}</div>
                
                ${variantSelectorHTML}

                <table class="product-specification">
                    ${specificationsHTML}
                </table>
                <div class="product-buttons" style="margin-top: 20px;">
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

    // --- INTERACTIVE SYSTEM EVENT LISTENERS ---
    const sizeItems = document.querySelectorAll("#sizeList .variant-item");
    if (sizeItems.length > 0 && product.sizes) {
        const updateVariantDOM = (index) => {
            const selectedVariant = product.sizes[index];
            if (selectedVariant) {
                document.getElementById("dynamicPrice").textContent = `₹ ${formatPrice(selectedVariant.price)}`;
                
                // Adaptive breakdown injection switch inside table element upon item click
                const activeDims = formatDimensions(selectedVariant.dimensions);
                const sizeValue = activeDims ? activeDims : (selectedVariant.size || "-");
                document.getElementById("dynamicDimensionRows").innerHTML = generateDimensionRows(sizeValue);
                
                document.getElementById("detailWeight").textContent = selectedVariant.weight || "-";
            }
        };

        updateVariantDOM(0);

        sizeItems.forEach(item => {
            item.addEventListener("click", function() {
                sizeItems.forEach(i => i.classList.remove("active"));
                this.classList.add("active");
                
                const variantIndex = parseInt(this.dataset.index, 10);
                updateVariantDOM(variantIndex);
            });
        });
    }
}

/*=========================================
                FORMAT PRICE
=========================================*/

function formatPrice(price) {
    if (price === undefined || price === null || price === "") return "-";
    const value = parseFloat(price);
    if (isNaN(value)) {
        return price;
    }
    const suffix = typeof price === 'string' ? price.replace(/^[\d.,\s]+/, "") : "";
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
        const relatedDisplayPrice = getProductDisplayPrice(product);
        const relatedImageSrc = product.thumbnail || product.image || product.img || "";
        
        relatedProducts.insertAdjacentHTML("beforeend", `
            <div class="product-card">
                <div class="product-image">
                    <img src="${relatedImageSrc}" alt="${product.name}" loading="lazy">
                </div>
                <div class="product-content">
                    <h3>${product.name}</h3>
                    <div class="product-price">₹ ${relatedDisplayPrice}</div>
                    <a href="product-details.html?slug=${product.slug}" class="btn-primary">
                        View Details
                    </a>
                </div>
            </div>
        `);
    });

    cards = [...document.querySelectorAll(".product-card")];

    if (cards.length < 4) {
        stopAutoplay();
        prevBtn.style.display = "none";
        nextBtn.style.display = "none";
        track.style.transform = "none";
        track.style.transition = "none";
        track.classList.add("grid-view");
        return;
    }

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