/*=========================================================
                    PROJECTS CAI
=========================================================*/
const loader = document.getElementById("loader");

function showLoader() {
    if (!loader) return;
    loader.classList.add("active");
    document.body.classList.add("loading");
}

function hideLoader() {
    if (!loader) return;
    loader.classList.remove("active");
    document.body.classList.remove("loading");
}

/*=========================================================
                    WAIT FOR PAINT
=========================================================*/
const waitForPaint = () => new Promise(resolve => {
    requestAnimationFrame(() => {
        requestAnimationFrame(resolve);
    });
});

/*=========================================================
                    DOM ELEMENTS
=========================================================*/
const projectsGrid = document.getElementById("projectsGrid");

/*=========================================================
                    VARIABLES
=========================================================*/
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
        if (!response.ok) {
            throw new Error(`Unable to load projects.json (${response.status})`);
        }
        projects = await response.json();
        await renderProjects();
    } catch (error) {
        console.error("Project loading error:", error);
    } finally {
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
                <img src="${project.thumbnail}" alt="${project.title}" data-index="${index}" loading="lazy" decoding="async">
                <div class="project-info">
                    <h3>${project.title}</h3>
                    <h5>${project.category}</h5>
                    <span>View Project</span>
                </div>
            </div>
        `;
    });
    projectsGrid.innerHTML = html;
    /*
     * IMPORTANT:
     *
     * Do NOT preload all gallery images,
     * videos or YouTube URLs here.
     *
     * Only thumbnails are loaded initially.
     *
     * Full media loads when the user opens
     * the lightbox.
     */
    await waitForPaint();
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
        <img class="lightbox-image" alt="">
        <video class="lightbox-video" controls autoplay playsinline preload="metadata" style="display:none;">
        </video>
        <iframe class="lightbox-youtube" style="display:none;" title="YouTube video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
    </div>
    <div class="lightbox-info">
        <h3 class="lightbox-title"></h3>
        <p class="lightbox-category"></p>
        <span class="lightbox-counter"></span>
    </div>
`;
document.body.appendChild(lightbox);

/*=========================================================
                    LIGHTBOX ELEMENTS
=========================================================*/
const lightboxImage = lightbox.querySelector(".lightbox-image");
const lightboxVideo = lightbox.querySelector(".lightbox-video");
const lightboxYoutube = lightbox.querySelector(".lightbox-youtube");
const lightboxCount = lightbox.querySelector(".lightbox-counter");
const lightboxTitle = lightbox.querySelector(".lightbox-title");
const lightboxCategory = lightbox.querySelector(".lightbox-category");
const closeBtn = lightbox.querySelector(".close-lightbox");
const prevBtn = lightbox.querySelector(".lightbox-prev");
const nextBtn = lightbox.querySelector(".lightbox-next");

/*=========================================================
                    YOUTUBE HELPERS
=========================================================*/
function cleanYouTubeUrl(url) {
    if (!url || typeof url !== "string") {
        return "";
    }
    let cleanedUrl = url.trim();
    /*
     * Supports:
     *
     * [https://youtu.be/VIDEO_ID](https://youtu.be/VIDEO_ID)
     */
    const markdownMatch = cleanedUrl.match(/^\[[^\]]+\]\((https?:\/\/[^)]+)\)$/);
    if (markdownMatch) {
        cleanedUrl = markdownMatch[1];
    }
    cleanedUrl = cleanedUrl.replace(/^["']/, "").replace(/["']$/, "").trim();
    return cleanedUrl;
}

/*=========================================================
                    IS YOUTUBE URL
=========================================================*/
function isYouTubeUrl(url) {
    const cleanedUrl = cleanYouTubeUrl(url);
    if (!cleanedUrl) {
        return false;
    }
    return /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i.test(cleanedUrl);
}

/*=========================================================
                    GET YOUTUBE VIDEO ID
=========================================================*/
function getYouTubeVideoId(url) {
    const cleanedUrl = cleanYouTubeUrl(url);
    if (!cleanedUrl) {
        return null;
    }
    try {
        const parsed = new URL(cleanedUrl.startsWith("http") ? cleanedUrl : `https://${cleanedUrl}`);
        /*
         * youtu.be/VIDEO_ID
         */
        if (parsed.hostname === "youtu.be" || parsed.hostname === "www.youtu.be") {
            return parsed.pathname.split("/").filter(Boolean)[0] || null;
        }
        /*
         * youtube.com/watch?v=VIDEO_ID
         */
        const videoId = parsed.searchParams.get("v");
        if (videoId) {
            return videoId;
        }
        /*
         * youtube.com/embed/VIDEO_ID
         *
         * youtube.com/shorts/VIDEO_ID
         */
        const match = parsed.pathname.match(/\/(?:embed|shorts)\/([^/?#]+)/i);
        if (match) {
            return match[1];
        }
    } catch (error) {
        console.error("Invalid YouTube URL:", url, error);
    }
    return null;
}

/*=========================================================
                    YOUTUBE EMBED URL
=========================================================*/
function getYouTubeEmbedUrl(url) {
    const videoId = getYouTubeVideoId(url);
    if (!videoId) {
        return null;
    }
    return (`https://www.youtube.com/@ConcreteArtsIndiaembed/` + `${encodeURIComponent(videoId)}` + `?autoplay=1` + `&mute=1` + `&rel=0` + `&playsinline=1`);
}

/*=========================================================
                    HIDE ALL MEDIA
=========================================================*/
function hideAllMedia() {
    lightboxImage.style.display = "none";
    lightboxVideo.style.display = "none";
    lightboxYoutube.style.display = "none";
    lightboxImage.removeAttribute("src");
    lightboxVideo.pause();
    lightboxVideo.currentTime = 0;
    lightboxVideo.removeAttribute("src");
    lightboxVideo.load();
    lightboxYoutube.removeAttribute("src");
}

/*=========================================================
                    UPDATE LIGHTBOX
=========================================================*/
function updateLightbox() {
    return new Promise((resolve) => {
        const project = projects[currentIndex];
        if (!project) {
            resolve();
            return;
        }
        lightboxTitle.textContent = project.title || "";
        lightboxCategory.textContent = project.category || "";
        /*=================================================
                        GALLERY PROJECT
        =================================================*/
        if (project.type === "gallery") {
            const file = project.images[galleryImageIndex];
            lightboxCount.textContent = `${galleryImageIndex + 1} / ${project.images.length}`;
            /*=============================================
                        YOUTUBE
            =============================================*/
            if (isYouTubeUrl(file)) {
                hideAllMedia();
                const embedUrl = getYouTubeEmbedUrl(file);
                if (!embedUrl) {
                    console.error("Unable to create YouTube embed URL:", file);
                    resolve();
                    return;
                }
                lightboxYoutube.style.display = "block";
                /*
                 * IMPORTANT:
                 *
                 * Set onload BEFORE src.
                 * This ensures we don't miss the
                 * iframe load event.
                 */
                lightboxYoutube.onload = function() {
                    resolve();
                };
                lightboxYoutube.onerror = function() {
                    console.error("YouTube iframe failed:", embedUrl);
                    resolve();
                };
                lightboxYoutube.src = embedUrl;
                return;
            }
            /*=============================================
                        LOCAL VIDEO
            =============================================*/
            const cleanFile = cleanYouTubeUrl(file);
            const extension = cleanFile.split("?")[0].split("#")[0].split(".").pop().toLowerCase();
            const isVideo = ["mp4", "webm", "ogg", "mov"].includes(extension);
            if (isVideo) {
                hideAllMedia();
                lightboxVideo.style.display = "block";
                lightboxVideo.controls = true;
                lightboxVideo.autoplay = true;
                lightboxVideo.playsInline = true;
                lightboxVideo.muted = false;
                /*
                 * Set event before src.
                 */
                lightboxVideo.onloadeddata = function() {
                    lightboxVideo.play().catch(function(error) {
                        console.log(error);
                    });
                    resolve();
                };
                lightboxVideo.onerror = function() {
                    resolve();
                };
                lightboxVideo.src = file;
                lightboxVideo.load();
                return;
            }
            /*=============================================
                        GALLERY IMAGE
            =============================================*/
            hideAllMedia();
            lightboxImage.style.display = "block";
            /*
             * IMPORTANT:
             *
             * Set onload BEFORE src.
             */
            lightboxImage.onload = function() {
                resolve();
            };
            lightboxImage.onerror = function() {
                resolve();
            };
            lightboxImage.src = file;
            lightboxImage.alt = project.title;
            return;
        }
        /*=================================================
                        VIDEO PROJECT
        =================================================*/
        if (project.type === "video") {
            /*
             * YouTube video
             */
            if (isYouTubeUrl(project.source)) {
                hideAllMedia();
                const embedUrl = getYouTubeEmbedUrl(project.source);
                if (!embedUrl) {
                    console.error("Invalid YouTube URL:", project.source);
                    resolve();
                    return;
                }
                lightboxYoutube.style.display = "block";
                lightboxYoutube.onload = function() {
                    resolve();
                };
                lightboxYoutube.onerror = function() {
                    resolve();
                };
                lightboxYoutube.src = embedUrl;
                lightboxCount.textContent = `${currentIndex + 1} / ${projects.length}`;
                return;
            }
            /*
             * Local video
             */
            hideAllMedia();
            lightboxVideo.style.display = "block";
            lightboxVideo.controls = true;
            lightboxVideo.autoplay = true;
            lightboxVideo.playsInline = true;
            lightboxVideo.onloadeddata = function() {
                lightboxVideo.play().catch(function(error) {
                    console.log(error);
                });
                resolve();
            };
            lightboxVideo.onerror = function() {
                resolve();
            };
            lightboxVideo.src = project.source;
            lightboxVideo.load();
            lightboxCount.textContent = `${currentIndex + 1} / ${projects.length}`;
            return;
        }
        /*=================================================
                        IMAGE PROJECT
        =================================================*/
        hideAllMedia();
        lightboxImage.style.display = "block";
        lightboxImage.onload = function() {
            resolve();
        };
        lightboxImage.onerror = function() {
            resolve();
        };
        lightboxImage.src = project.source;
        lightboxImage.alt = project.title;
        lightboxCount.textContent = `${currentIndex + 1} / ${projects.length}`;
    });
}

/*=========================================================
                    OPEN LIGHTBOX
=========================================================*/
async function openLightbox(index) {
    if (!projects.length) {
        return;
    }
    /*
     * ================================================
     * STEP 1
     * ================================================
     *
     * Show loader IMMEDIATELY when thumbnail
     * is clicked.
     */
    showLoader();
    /*
     * Set current project.
     */
    currentIndex = index;
    /*
     * Every new project starts from
     * the first gallery item.
     */
    galleryImageIndex = 0;
    /*
     * ================================================
     * STEP 2
     * ================================================
     *
     * Give the browser an opportunity to
     * actually paint the loader.
     */
    await waitForPaint();
    /*
     * ================================================
     * STEP 3
     * ================================================
     *
     * Load the lightbox media.
     *
     * This function resolves ONLY after:
     *
     * IMAGE  -> image.onload
     * VIDEO  -> video.onloadeddata
     * YOUTUBE -> iframe.onload
     */
    await updateLightbox();
    /*
     * ================================================
     * STEP 4
     * ================================================
     *
     * Media is now ready.
     *
     * Show the lightbox.
     */
    lightbox.classList.add("active");
    document.body.style.overflow = "hidden";
    /*
     * ================================================
     * STEP 5
     * ================================================
     *
     * Lightbox is visible and media is loaded.
     *
     * Hide loader.
     */
    hideLoader();
}

/*=========================================================
                    CLOSE LIGHTBOX
=========================================================*/
function closeLightbox() {
    lightbox.classList.remove("active");
    document.body.style.overflow = "";
    /*
     * Stop local video.
     */
    lightboxVideo.pause();
    lightboxVideo.currentTime = 0;
    lightboxVideo.removeAttribute("src");
    lightboxVideo.load();
    /*
     * Stop YouTube iframe.
     */
    lightboxYoutube.removeAttribute("src");
    lightboxYoutube.style.display = "none";
    /*
     * Clear image.
     */
    lightboxImage.removeAttribute("src");
}

/*=========================================================
                    NEXT IMAGE
=========================================================*/
async function nextImage() {
    showLoader();
    /*
     * Stop currently playing media.
     */
    lightboxVideo.pause();
    lightboxVideo.currentTime = 0;
    lightboxYoutube.removeAttribute("src");
    lightboxYoutube.style.display = "none";
    await waitForPaint();
    const project = projects[currentIndex];
    if (!project) {
        hideLoader();
        return;
    }
    /*=================================================
                    GALLERY
    =================================================*/
    if (project.type === "gallery") {
        galleryImageIndex++;
        if (galleryImageIndex >= project.images.length) {
            galleryImageIndex = 0;
        }
    }
    /*=================================================
                NORMAL / VIDEO PROJECT
    =================================================*/
    else {
        currentIndex++;
        if (currentIndex >= projects.length) {
            currentIndex = 0;
        }
        galleryImageIndex = 0;
    }
    /*
     * Load next media.
     */
    await updateLightbox();
    /*
     * Media ready.
     */
    hideLoader();
}

/*=========================================================
                    PREVIOUS IMAGE
=========================================================*/
async function previousImage() {
    showLoader();
    /*
     * Stop currently playing media.
     */
    lightboxVideo.pause();
    lightboxVideo.currentTime = 0;
    lightboxYoutube.removeAttribute("src");
    lightboxYoutube.style.display = "none";
    await waitForPaint();
    const project = projects[currentIndex];
    if (!project) {
        hideLoader();
        return;
    }
    /*=================================================
                    GALLERY
    =================================================*/
    if (project.type === "gallery") {
        galleryImageIndex--;
        if (galleryImageIndex < 0) {
            galleryImageIndex = project.images.length - 1;
        }
    }
    /*=================================================
                NORMAL / VIDEO PROJECT
    =================================================*/
    else {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = projects.length - 1;
        }
        galleryImageIndex = 0;
    }
    /*
     * Load previous media.
     */
    await updateLightbox();
    /*
     * Media ready.
     */
    hideLoader();
}

/*=========================================================
                    PROJECT CLICK
=========================================================*/
projectsGrid.addEventListener("click", async function(event) {
    const img = event.target.closest(".project-card img");
    if (!img) {
        return;
    }
    const index = Number(img.dataset.index);
    /*
     * openLightbox() itself handles:
     *
     * showLoader()
     * loading media
     * opening lightbox
     * hideLoader()
     */
    await openLightbox(index);
});

/*=========================================================
                    CLOSE BUTTON
=========================================================*/
closeBtn.addEventListener("click", closeLightbox);
/*=========================================================
                    NEXT BUTTON
=========================================================*/
nextBtn.addEventListener("click", nextImage);
/*=========================================================
                    PREVIOUS BUTTON
=========================================================*/
prevBtn.addEventListener("click", previousImage);
/*=========================================================
                    CLICK OUTSIDE
=========================================================*/
lightbox.addEventListener("click", function(event) {
    if (event.target === lightbox) {
        closeLightbox();
    }
});

/*=========================================================
                    KEYBOARD NAVIGATION
=========================================================*/
document.addEventListener("keydown", async function(event) {
    if (!lightbox.classList.contains("active")) {
        return;
    }
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
lightbox.addEventListener("touchstart", function(event) {
    touchStartX = event.changedTouches[0].screenX;
});
lightbox.addEventListener("touchend", async function(event) {
    touchEndX = event.changedTouches[0].screenX;
    /*
     * Swipe left
     */
    if (touchStartX - touchEndX > 50) {
        await nextImage();
    }
    /*
     * Swipe right
     */
    else if (touchEndX - touchStartX > 50) {
        await previousImage();
    }
});

/*=========================================================
                    VIDEO ENDED
=========================================================*/
lightboxVideo.addEventListener("ended", async function() {
    const project = projects[currentIndex];
    if (!project) {
        return;
    }
    /*
     * If the video is part of a gallery,
     * automatically move to the next item.
     */
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