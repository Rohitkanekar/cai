/*=========================================
                GALLERY
=========================================*/

const loader = document.getElementById("loader");

function showLoader() {

    loader.classList.add("active");

    document.body.classList.add("loading");

}

function hideLoader() {

    loader.classList.remove("active");

    document.body.classList.remove("loading");

}

/*=========================================
            DOM ELEMENTS
=========================================*/

const galleryGrid = document.getElementById("galleryGrid");

const galleryPagination = document.getElementById("galleryPagination");

const filterButtons = document.querySelectorAll(".gallery-filter a");

const lightbox = document.querySelector(".lightbox");

const lightboxImage = lightbox.querySelector("img");

const closeBtn = document.querySelector(".close-lightbox");

const prevBtn = document.querySelector(".lightbox-prev");

const nextBtn = document.querySelector(".lightbox-next");

/*=========================================
            LIGHTBOX INFO
=========================================*/

let lightboxInfo = lightbox.querySelector(".lightbox-info");

let lightboxTitle = lightbox.querySelector(".lightbox-title");

let lightboxCounter = lightbox.querySelector(".lightbox-counter");

if (!lightboxInfo) {

    lightboxInfo = document.createElement("div");

    lightboxInfo.className = "lightbox-info";

    lightboxTitle = document.createElement("h3");

    lightboxTitle.className = "lightbox-title";

    lightboxCounter = document.createElement("span");

    lightboxCounter.className = "lightbox-counter";

    lightboxInfo.appendChild(lightboxTitle);

    lightboxInfo.appendChild(lightboxCounter);

    lightbox.appendChild(lightboxInfo);

}

/*=========================================
            VARIABLES
=========================================*/

let allProducts = [];

let filteredProducts = [];

let galleryItems = [];

let visibleProducts = [];

const perPage = 12;

let currentPage = 1;

let currentIndex = 0;

/*=========================================
            LOAD GALLERY
=========================================*/

async function loadGallery() {

    showLoader();

    try {

        const response = await fetch("api/products.php");

        const data = await response.json();

        allProducts = Array.isArray(data)
            ? data
            : (data.products || data.data || []);

        filteredProducts = [...allProducts];

        renderGallery();

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

function renderGallery() {

    galleryGrid.innerHTML = "";

    const start = (currentPage - 1) * perPage;

    const end = start + perPage;

    const pageProducts = filteredProducts.slice(start, end);

    pageProducts.forEach(product => {

        const category = typeof product.category === "object"

            ? (product.category.name || product.category.slug || "")

            : (product.category || "");

        const categoryClass = category
            .toLowerCase()
            .replace(/\s+/g, "-");

        const image = product.thumbnail ||

            (product.images?.length

                ? (product.images[0].image || product.images[0])

                : "images/no-image.webp");

        galleryGrid.insertAdjacentHTML("beforeend", `

            <div class="gallery-item ${categoryClass}">

                <img
                    src="${image}"
                    alt="${product.name}"
                    loading="lazy">

                <div class="gallery-overlay">

                    <h3>${product.name}</h3>

                    <span>View Image</span>

                </div>

            </div>

        `);

    });

    galleryItems = [...document.querySelectorAll(".gallery-item")];

    bindGalleryEvents();

    renderPagination();

}

/*=========================================
            FILTER
=========================================*/

filterButtons.forEach(button => {

    button.addEventListener("click", function (event) {

        event.preventDefault();

        filterButtons.forEach(item => {

            item.classList.remove("active");

        });

        this.classList.add("active");

        const filter = this.dataset.filter;

        if (filter === "all") {

            filteredProducts = [...allProducts];

        }

        else {

            filteredProducts = allProducts.filter(product => {

                const category = typeof product.category === "object"

                    ? (product.category.slug || product.category.name || "")

                    : product.category;

                return category
                    .toLowerCase()
                    .replace(/\s+/g, "-") === filter;

            });

        }

        currentPage = 1;

        renderGallery();

    });

});

/*=========================================
            PAGINATION
=========================================*/

function renderPagination() {

    galleryPagination.innerHTML = "";

    const totalPages = Math.ceil(filteredProducts.length / perPage);

    if (totalPages <= 1) {

        galleryPagination.style.display = "none";

        return;

    }

    galleryPagination.style.display = "flex";

    let html = "";

    /*==============================
            PREVIOUS
    ==============================*/

    html += `

        <button
            class="page-btn prev-page"
            ${currentPage === 1 ? "disabled" : ""}>

            <i class="fa-solid fa-chevron-left"></i>

        </button>

    `;

    /*==============================
            PAGE NUMBERS
    ==============================*/

    for (let i = 1; i <= totalPages; i++) {

        html += `

            <button
                class="page-btn ${i === currentPage ? "active" : ""}"
                data-page="${i}">

                ${i}

            </button>

        `;

    }

    /*==============================
            NEXT
    ==============================*/

    html += `

        <button
            class="page-btn next-page"
            ${currentPage === totalPages ? "disabled" : ""}>

            <i class="fa-solid fa-chevron-right"></i>

        </button>

    `;

    galleryPagination.innerHTML = html;

    /*==============================
            PAGE CLICK
    ==============================*/

    galleryPagination
        .querySelectorAll("[data-page]")
        .forEach(button => {

            button.addEventListener("click", function () {

                currentPage = Number(this.dataset.page);

                renderGallery();

                window.scrollTo({

                    top: galleryGrid.offsetTop - 120,

                    behavior: "smooth"

                });

            });

        });

    /*==============================
            PREVIOUS
    ==============================*/

    const prev = galleryPagination.querySelector(".prev-page");

    prev.addEventListener("click", function () {

        if (this.disabled) return;

        currentPage--;

        renderGallery();

        window.scrollTo({

            top: galleryGrid.offsetTop - 120,

            behavior: "smooth"

        });

    });

    /*==============================
            NEXT
    ==============================*/

    const next = galleryPagination.querySelector(".next-page");

    next.addEventListener("click", function () {

        if (this.disabled) return;

        currentPage++;

        renderGallery();

        window.scrollTo({

            top: galleryGrid.offsetTop - 120,

            behavior: "smooth"

        });

    });

}

/*=========================================
            BIND GALLERY EVENTS
=========================================*/

function bindGalleryEvents() {

    galleryItems.forEach((item, index) => {

        item.addEventListener("click", function () {

            /* All filtered products, not just current page */
            visibleProducts = [...filteredProducts];

            /* Current product index in filtered array */
            currentIndex = ((currentPage - 1) * perPage) + index;

            showImage();

        });

    });

}

/*=========================================
            SHOW IMAGE
=========================================*/

function showImage() {

    if (!visibleProducts.length) return;

    const product = visibleProducts[currentIndex];

    const image =

        product.thumbnail ||

        (
            product.images &&
            product.images.length
                ? (product.images[0].image || product.images[0])
                : "images/no-image.webp"
        );

    lightboxImage.src = image;

    lightboxImage.alt = product.name;

    lightboxTitle.textContent = product.name;

    lightboxCounter.textContent =
        `${currentIndex + 1} / ${visibleProducts.length}`;

    lightbox.classList.add("active");

    document.body.style.overflow = "hidden";

}

/*=========================================
            NEXT IMAGE
=========================================*/

function nextImage() {

    currentIndex++;

    if (currentIndex >= visibleProducts.length) {

        currentIndex = 0;

    }

    showImage();

}

/*=========================================
            PREVIOUS IMAGE
=========================================*/

function previousImage() {

    currentIndex--;

    if (currentIndex < 0) {

        currentIndex = visibleProducts.length - 1;

    }

    showImage();

}

/*=========================================
            CLOSE LIGHTBOX
=========================================*/

function closeLightbox() {

    lightbox.classList.remove("active");

    document.body.style.overflow = "";

}

/*=========================================
            BUTTON EVENTS
=========================================*/

nextBtn.addEventListener("click", nextImage);

prevBtn.addEventListener("click", previousImage);

closeBtn.addEventListener("click", closeLightbox);

/*=========================================
            CLICK OUTSIDE
=========================================*/

lightbox.addEventListener("click", function (event) {

    if (event.target === lightbox) {

        closeLightbox();

    }

});

/*=========================================
            KEYBOARD NAVIGATION
=========================================*/

document.addEventListener("keydown", function (event) {

    if (!lightbox.classList.contains("active")) return;

    switch (event.key) {

        case "Escape":

            closeLightbox();

            break;

        case "ArrowRight":

            nextImage();

            break;

        case "ArrowLeft":

            previousImage();

            break;

    }

});

/*=========================================
            TOUCH SWIPE
=========================================*/

let touchStartX = 0;

let touchEndX = 0;

lightbox.addEventListener("touchstart", function (event) {

    touchStartX = event.changedTouches[0].screenX;

});

lightbox.addEventListener("touchend", function (event) {

    touchEndX = event.changedTouches[0].screenX;

    if (touchStartX - touchEndX > 50) {

        nextImage();

    }

    if (touchEndX - touchStartX > 50) {

        previousImage();

    }

});

/*=========================================
            IMAGE LOAD
=========================================*/

lightboxImage.addEventListener("load", function () {

    this.style.opacity = "1";

});

/*=========================================
            IMAGE ERROR
=========================================*/

lightboxImage.addEventListener("error", function () {

    this.src = "images/no-image.webp";

});

/*=========================================
            PRELOAD NEXT IMAGE
=========================================*/

function preloadNextImage() {

    if (!visibleProducts.length) return;

    let nextIndex = currentIndex + 1;

    if (nextIndex >= visibleProducts.length) {

        nextIndex = 0;

    }

    const product = visibleProducts[nextIndex];

    const image =

        product.thumbnail ||

        (
            product.images &&
            product.images.length
                ? (product.images[0].image || product.images[0])
                : "images/no-image.webp"
        );

    const preload = new Image();

    preload.src = image;

}

/*=========================================
            UPDATE PRELOAD
=========================================*/

const originalShowImage = showImage;

showImage = function () {

    originalShowImage();

    preloadNextImage();

};

/*=========================================
            START
=========================================*/

loadGallery();