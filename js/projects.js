/*=========================================================
                    PROJECTS
=========================================================*/

const loader = document.getElementById("loader");

function showLoader() {

    loader.classList.add("active");

    document.body.classList.add("loading");

}

function hideLoader() {

    loader.classList.remove("active");

    document.body.classList.remove("loading");

}

// Helper to ensure the browser actually paints the loader on screen before heavy work starts
const waitForPaint = () => new Promise(resolve => {
    requestAnimationFrame(() => {
        requestAnimationFrame(resolve);
    });
});

const projectsGrid = document.getElementById("projectsGrid");

let projects = [];

let currentIndex = 0;

let galleryImageIndex = 0;

/*=========================================================
                    LOAD PROJECTS
=========================================================*/

async function loadProjects() {

    showLoader();

    try {

        const response = await fetch("data/projects.json");

        projects = await response.json();

        await renderProjects();

    }

    catch (error) {

        console.error(error);

        hideLoader();

    }

}

/*=========================================================
                    RENDER PROJECTS
=========================================================*/

async function renderProjects() {

    let html = "";

    projects.forEach((project, index) => {

        html += `

            <div class="project-card">

                <img
                    src="${project.thumbnail}"
                    alt="${project.title}"
                    data-index="${index}">

                <div class="project-info">

                    <h3>${project.title}</h3>

                    <h5>${project.category}</h5>

                    <span>View Project</span>

                </div>

            </div>

        `;

    });

    projectsGrid.innerHTML = html;

    const assetUrls = new Set();
    projects.forEach(project => {
        if (project.thumbnail) assetUrls.add(project.thumbnail);
        if (project.source) assetUrls.add(project.source);
        if (project.type === "gallery" && Array.isArray(project.images)) {
            project.images.forEach(img => assetUrls.add(img));
        }
    });

    const promises = Array.from(assetUrls).map(url => {
        return new Promise((resolve) => {
            const ext = url.split(".").pop().toLowerCase();
            const isVideo = ["mp4", "webm", "ogg", "mov"].includes(ext);

            if (isVideo) {
                const video = document.createElement("video");
                video.src = url;
                video.preload = "metadata";
                video.onloadeddata = resolve;
                video.onerror = resolve;
            } else {
                const img = new Image();
                img.src = url;
                img.onload = resolve;
                img.onerror = resolve;
            }
        });
    });

    await Promise.all(promises);

    hideLoader();

}

/*=========================================================
                    LIGHTBOX
=========================================================*/

const lightbox = document.createElement("div");

lightbox.className = "lightbox";

lightbox.innerHTML = `

    <span class="close-lightbox">

        <i class="fa fa-close"></i>

    </span>

    <button class="lightbox-prev">

        <i class="fa-solid fa-chevron-left"></i>

    </button>

    <button class="lightbox-next">

        <i class="fa-solid fa-chevron-right"></i>

    </button>

    <div class="lightbox-content">

        <img
            class="lightbox-image"
            alt="">

        <video
            class="lightbox-video"
            controls
            autoplay
            playsinline
            preload="metadata"
            style="display:none;">
        </video>

    </div>

    <div class="lightbox-info">

        <h3 class="lightbox-title"></h3>

        <p class="lightbox-category"></p>

        <span class="lightbox-counter"></span>

    </div>

`;

document.body.appendChild(lightbox);

const lightboxImage = lightbox.querySelector(".lightbox-image");

const lightboxVideo = lightbox.querySelector(".lightbox-video");

const lightboxCount = lightbox.querySelector(".lightbox-counter");

const lightboxTitle = lightbox.querySelector(".lightbox-title");

const lightboxCategory = lightbox.querySelector(".lightbox-category");

const closeBtn = lightbox.querySelector(".close-lightbox");

const prevBtn = lightbox.querySelector(".lightbox-prev");

const nextBtn = lightbox.querySelector(".lightbox-next");

/*=========================================================
            UPDATE LIGHTBOX
=========================================================*/

function updateLightbox() {

    return new Promise((resolve) => {

        const project = projects[currentIndex];

        lightboxTitle.textContent = project.title;

        lightboxCategory.textContent = project.category;

        /*====================================
                    GALLERY
        ====================================*/

        if (project.type === "gallery") {

            const file = project.images[galleryImageIndex];

            const extension = file.split(".").pop().toLowerCase();

            const isVideo = [
                "mp4",
                "webm",
                "ogg",
                "mov"
            ].includes(extension);

            /*==========================
                    GALLERY VIDEO
            ==========================*/

            if (isVideo) {

                lightboxImage.style.display = "none";

                lightboxImage.removeAttribute("src");

                lightboxVideo.style.display = "block";

                lightboxVideo.pause();

                lightboxVideo.currentTime = 0;

                lightboxVideo.src = file;

                lightboxVideo.controls = true;

                lightboxVideo.autoplay = true;

                lightboxVideo.playsInline = true;

                lightboxVideo.load();

                lightboxVideo.onloadeddata = function () {

                    lightboxVideo.play().catch(function (error) {

                        console.log(error);

                    });

                    resolve();

                };

                lightboxVideo.onerror = function () {

                    resolve();

                };

            }

            /*==========================
                    GALLERY IMAGE
            ==========================*/

            else {

                lightboxVideo.pause();

                lightboxVideo.currentTime = 0;

                lightboxVideo.removeAttribute("src");

                lightboxVideo.load();

                lightboxVideo.style.display = "none";

                lightboxImage.style.display = "block";

                lightboxImage.onload = function () {

                    resolve();

                };

                lightboxImage.onerror = function () {

                    resolve();

                };

                lightboxImage.src = file;

                lightboxImage.alt = project.title;

            }

            lightboxCount.textContent =
                `${galleryImageIndex + 1} / ${project.images.length}`;

        }

        /*====================================
                    VIDEO PROJECT
        ====================================*/

        else if (project.type === "video") {

            lightboxImage.style.display = "none";

            lightboxImage.removeAttribute("src");

            lightboxVideo.style.display = "block";

            lightboxVideo.pause();

            lightboxVideo.currentTime = 0;

            lightboxVideo.src = project.source;

            lightboxVideo.controls = true;

            lightboxVideo.autoplay = true;

            lightboxVideo.playsInline = true;

            lightboxVideo.load();

            lightboxVideo.onloadeddata = function () {

                lightboxVideo.play().catch(function (error) {

                    console.log(error);

                });

                resolve();

            };

            lightboxVideo.onerror = function () {

                resolve();

            };

            lightboxCount.textContent =
                `${currentIndex + 1} / ${projects.length}`;

        }

        /*====================================
                    IMAGE PROJECT
        ====================================*/

        else {

            lightboxVideo.pause();

            lightboxVideo.currentTime = 0;

            lightboxVideo.removeAttribute("src");

            lightboxVideo.load();

            lightboxVideo.style.display = "none";

            lightboxImage.style.display = "block";

            lightboxImage.onload = function () {

                resolve();

            };

            lightboxImage.onerror = function () {

                resolve();

            };

            lightboxImage.src = project.source;

            lightboxImage.alt = project.title;

            lightboxCount.textContent =
                `${currentIndex + 1} / ${projects.length}`;

        }

    });

}

/*=========================================================
                    OPEN
=========================================================*/

async function openLightbox(index) {

    showLoader();

    currentIndex = index;

    galleryImageIndex = 0;

    await waitForPaint();

    await updateLightbox();

    lightbox.classList.add("active");

    document.body.style.overflow = "hidden";

    hideLoader();

}

/*=========================================================
                    CLOSE
=========================================================*/

function closeLightbox() {

    lightbox.classList.remove("active");

    document.body.style.overflow = "";

    lightboxVideo.pause();

    lightboxVideo.currentTime = 0;

    lightboxVideo.removeAttribute("src");

    lightboxVideo.load();

}

/*=========================================================
                    NEXT
=========================================================*/

async function nextImage() {

    showLoader();

    lightboxVideo.pause();

    lightboxVideo.currentTime = 0;

    await waitForPaint();

    const project = projects[currentIndex];

    /*====================================
                GALLERY
    ====================================*/

    if (project.type === "gallery") {

        galleryImageIndex++;

        if (galleryImageIndex >= project.images.length) {

            galleryImageIndex = 0;

        }

    }

    /*====================================
                NORMAL PROJECT
    ====================================*/

    else {

        currentIndex++;

        if (currentIndex >= projects.length) {

            currentIndex = 0;

        }

        galleryImageIndex = 0;

    }

    await updateLightbox();

    hideLoader();

}

/*=========================================================
                    PREVIOUS
=========================================================*/

async function previousImage() {

    showLoader();

    lightboxVideo.pause();

    lightboxVideo.currentTime = 0;

    await waitForPaint();

    const project = projects[currentIndex];

    /*====================================
                GALLERY
    ====================================*/

    if (project.type === "gallery") {

        galleryImageIndex--;

        if (galleryImageIndex < 0) {

            galleryImageIndex = project.images.length - 1;

        }

    }

    /*====================================
                NORMAL PROJECT
    ====================================*/

    else {

        currentIndex--;

        if (currentIndex < 0) {

            currentIndex = projects.length - 1;

        }

        galleryImageIndex = 0;

    }

    await updateLightbox();

    hideLoader();

}

/*=========================================================
                    EVENTS
=========================================================*/

projectsGrid.addEventListener("click", async function (event) {

    const img = event.target.closest(".project-card img");

    if (img) {

        await openLightbox(Number(img.dataset.index));

    }

});

closeBtn.addEventListener("click", closeLightbox);

nextBtn.addEventListener("click", nextImage);

prevBtn.addEventListener("click", previousImage);

lightbox.addEventListener("click", function (event) {

    if (event.target === lightbox) {

        closeLightbox();

    }

});

/*=========================================================
                    KEYBOARD
=========================================================*/

document.addEventListener("keydown", async function (event) {

    if (!lightbox.classList.contains("active")) return;

    switch (event.key) {

        case "Escape":

            closeLightbox();

            break;

        case "ArrowRight":

            await nextImage();

            break;

        case "ArrowLeft":

            await previousImage();

            break;

    }

});

/*=========================================================
                    TOUCH SWIPE
=========================================================*/

let touchStartX = 0;

let touchEndX = 0;

lightbox.addEventListener("touchstart", function (event) {

    touchStartX = event.changedTouches[0].screenX;

});

lightbox.addEventListener("touchend", async function (event) {

    touchEndX = event.changedTouches[0].screenX;

    if (touchStartX - touchEndX > 50) {

        await nextImage();

    }

    else if (touchEndX - touchStartX > 50) {

        await previousImage();

    }

});

/*=========================================================
                    VIDEO ENDED
=========================================================*/

lightboxVideo.addEventListener("ended", async function () {

    const project = projects[currentIndex];

    if (project.type === "gallery") {

        showLoader();

        galleryImageIndex++;

        if (galleryImageIndex >= project.images.length) {

            galleryImageIndex = 0;

        }

        await waitForPaint();

        await updateLightbox();

        hideLoader();

    }

});

/*=========================================================
                    START
=========================================================*/

loadProjects();