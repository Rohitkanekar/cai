

/*========================================= GALLERY =========================================*/

const loader = document.getElementById("loader");

function showLoader() {
    loader.classList.add("active");
    document.body.classList.add('loading');
}

function hideLoader() {
    loader.classList.remove("active");
    document.body.classList.remove('loading');
}

const galleryGrid = document.getElementById("galleryGrid");
const galleryPagination = document.getElementById("galleryPagination");
const filterButtons = document.querySelectorAll(".gallery-filter a");
const lightbox = document.querySelector(".lightbox");
const lightboxImage = lightbox.querySelector("img");
const closeBtn = document.querySelector(".close-lightbox");
const prevBtn = document.querySelector(".lightbox-prev");
const nextBtn = document.querySelector(".lightbox-next");

/* Create or select a counter element dynamically if it doesn't exist in HTML */
let lightboxCounter = lightbox.querySelector(".lightbox-counter");
if (!lightboxCounter) {
    lightboxCounter = document.createElement("div");
    lightboxCounter.className = "lightbox-counter";
    // Insert it near the navigation buttons or top of lightbox
    lightbox.appendChild(lightboxCounter);
}

let allProducts = [];
let filteredProducts = [];
const perPage = 12;
let currentPage = 1;
let galleryItems = [];
let visibleItems = [];
let currentIndex = 0;

/*=========================================
            LOAD PRODUCTS
=========================================*/

async function loadGallery() {
    showLoader();
    try {
        const response = await fetch("api/products.php");
        const data = await response.json();

        /* Handle cases where API returns an object containing the array (e.g. { products: [...] }) */
        const productsArray = Array.isArray(data)
            ? data
            : (data.products || data.data || []);

        renderGallery(productsArray);
    }
    catch (error) {
        console.error(error);
    }
    finally {
        hideLoader();
    }
}

/*=========================================
            RENDER GALLERY
=========================================*/

function renderGallery(products) {
    galleryGrid.innerHTML = "";

    /* Fallback safety check if products is still not an array */
    if (!Array.isArray(products)) {
        console.error("renderGallery received non-array data:", products);
        return;
    }

    products.forEach(product => {
        /* Safely extract category name/string for class names */
        const catValue = typeof product.category === "object"
            ? (product.category?.name || product.category?.slug || "")
            : (product.category || "");

        const categoryClass = catValue.toLowerCase().replace(/\s+/g, '-');

        /* Safely extract image path */
        const imagePath = product.thumbnail || (product.images && product.images.length > 0 ? (product.images[0].image || product.images[0]) : "images/no-image.webp");

        galleryGrid.insertAdjacentHTML("beforeend", `
                <div class="gallery-item ${categoryClass}">
                    <img src="${imagePath}" alt="${product.name || 'Gallery Image'}" loading="lazy">
                    <div class="gallery-overlay">
                        <h3>${product.name || "-"}</h3>
                        <span>View Image</span>
                    </div>
                </div>
            `);
    });

    galleryItems = [...document.querySelectorAll(".gallery-item")];
    if (typeof bindGalleryEvents === "function") {
        bindGalleryEvents();
    }
}
/*=========================================
            FILTER
=========================================*/

filterButtons.forEach(button => {
    button.addEventListener("click", () => {
        document.querySelector(".gallery-filter .active").classList.remove("active");
        button.classList.add("active");
        const filter = button.dataset.filter;
        galleryItems.forEach(item => {
            if (filter === "all" || item.classList.contains(filter)) {
                item.style.display = "block";
            }
            else {
                item.style.display = "none";
            }
        });
    });
});

/*=========================================
            BIND EVENTS
=========================================*/

function bindGalleryEvents() {
    galleryItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            visibleItems = galleryItems.filter(card =>
                card.style.display !== "none"
            );
            currentIndex = visibleItems.indexOf(item);
            showImage();
        });
    });
}

/*=========================================
            SHOW IMAGE & COUNTER
=========================================*/

function showImage() {
    const image = visibleItems[currentIndex].querySelector("img");
    lightboxImage.src = image.src;
    lightboxImage.alt = image.alt;

    /* Update the counter text (e.g. 1 / 50) */
    if (lightboxCounter) {
        lightboxCounter.textContent = `${currentIndex + 1} / ${visibleItems.length}`;
    }

    lightbox.classList.add("active");
}

/*=========================================
            NEXT
=========================================*/

nextBtn.addEventListener("click", () => {
    currentIndex++;
    if (currentIndex >= visibleItems.length) {
        currentIndex = 0;
    }
    showImage();
});

/*=========================================
            PREVIOUS
=========================================*/

prevBtn.addEventListener("click", () => {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = visibleItems.length - 1;
    }
    showImage();
});

/*=========================================
            CLOSE
=========================================*/

closeBtn.addEventListener("click", () => {
    lightbox.classList.remove("active");
});
lightbox.addEventListener("click", e => {
    if (e.target === lightbox) {
        lightbox.classList.remove("active");
    }
});

/*=========================================
            KEYBOARD
=========================================*/

document.addEventListener("keydown", e => {
    if (!lightbox.classList.contains("active")) return;
    if (e.key === "Escape") {
        lightbox.classList.remove("active");
    }
    if (e.key === "ArrowRight") {
        nextBtn.click();
    }
    if (e.key === "ArrowLeft") {
        prevBtn.click();
    }
});

/*=========================================
            START
=========================================*/

loadGallery();
