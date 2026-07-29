/*=========================================================
                    SORTING
=========================================================*/

const sourceBtn = document.getElementById("sourceBtn");
const sourceError = document.getElementById("sourceError");
const sourceMenu = document.getElementById("sourceMenu");
const sourceInput = document.getElementById("source");
const selectedSource = document.getElementById("selectedSource");
const productCard = document.getElementById("selectedProduct");
const loader = document.getElementById("loader");
const form = document.getElementById("contactForm");
const params = new URLSearchParams(window.location.search);
const slug = params.get("slug");
let selectedSizeData = null;
let selectedProduct = null;

sourceBtn.addEventListener("click", () => {
    sourceBtn.classList.toggle("active");
    sourceMenu.classList.toggle("show");
});

sourceMenu.querySelectorAll("li").forEach(item => {
    item.addEventListener("click", () => {
        selectedSource.textContent = item.textContent;
        sourceInput.value = item.dataset.value;
        sourceMenu.classList.remove("show");
        sourceBtn.classList.remove("active");
    });
});

document.addEventListener("click", function (e) {
    if (!sourceBtn.contains(e.target) &&
        !sourceMenu.contains(e.target)) {
        sourceMenu.classList.remove("show");
        sourceBtn.classList.remove("active");
    }
});

function showLoader() {
    loader.classList.add("active");
    document.body.classList.add('loading');
}

function hideLoader() {
    loader.classList.remove("active");
    document.body.classList.remove('loading');
}

/* Helper to safely get category string name */
function getCategoryName(cat) {
    if (!cat) return "";
    if (typeof cat === "object") {
        return String(cat.name || cat.slug || "").toLowerCase().trim();
    }
    return String(cat).toLowerCase().trim();
}

async function loadSelectedProduct() {

    productCard.style.display = "block";

    // Contact page without slug
    if (!slug) {
        selectedProduct = null;
        productCard.style.display = "none";
        return;
    }

    try {
        showLoader();
        const response = await fetch("api/products.php");
        const data = await response.json();
        const products = Array.isArray(data) ? data : (data.products || data.data || []);
        const product = products.find(item => item.slug === slug);
        if (!product) {
            selectedProduct = null;
            productCard.style.display = "none";
            return;
        }
        selectedProduct = product;
        const catName = getCategoryName(product.category);
        const isPlanter = catName.includes('planter');
        const hasSizes = product.sizes && product.sizes.length > 0;
        if (hasSizes) {
            selectedProduct.selectedSize =
                params.get("size") || product.sizes[0].size;

            selectedSizeData =
                product.sizes.find(item => item.size === selectedProduct.selectedSize)
                || product.sizes[0];

            selectedProduct.selectedPrice = selectedSizeData.price;
        }

        const productNameInput = document.getElementById("productName");
        if (productNameInput) productNameInput.value = product.name;

        const displayPrice = hasSizes
            ? selectedProduct.selectedPrice
            : (product.price || (product.size && product.size.price) || "-");

        const displaySize = hasSizes
            ? selectedProduct.selectedSize
            : (product.size?.size || product.size || "-");

        const displayCategory = typeof product.category === "object"
            ? (product.category.name || "-")
            : (product.category || "-");

        let featuresList = [];
        if (Array.isArray(product.features)) {
            featuresList = product.features;
        } else if (typeof product.features === "string" && product.features.trim() !== "") {
            featuresList = product.features.split(/[\n,]+/).map(f => f.trim()).filter(Boolean);
        }

        const featuresHTML = featuresList.length > 0
            ? featuresList.map(feature => `<li>${feature}</li>`).join("")
            : "<li>-</li>";

        let dimensionRowsHTML = "";
        if (isPlanter) {
            if (hasSizes && selectedSizeData && selectedSizeData.dimensions) {
                dimensionRowsHTML = `
                    <tr>
                        <th>Size</th>
                        <td>${displaySize}</td>
                    </tr>
                    <tr>
                        <th>Length</th>
                        <td>${selectedSizeData.dimensions.length?.mm || "-"} mm (${selectedSizeData.dimensions.length?.inch || "-"})</td>
                    </tr>
                    <tr>
                        <th>Breadth</th>
                        <td>${selectedSizeData.dimensions.breadth?.mm || "-"} mm (${selectedSizeData.dimensions.breadth?.inch || "-"})</td>
                    </tr>
                    <tr>
                        <th>Height</th>
                        <td>${selectedSizeData.dimensions.height?.mm || "-"} mm (${selectedSizeData.dimensions.height?.inch || "-"})</td>
                    </tr>
                `;
            } else {
                dimensionRowsHTML = `
                    <tr>
                        <th>Size</th>
                        <td>${displaySize}</td>
                    </tr>
                `;
            }
        } else {
            dimensionRowsHTML = `
                ${displaySize !== "-" && displaySize !== "" ? `
                <tr>
                    <th>Size</th>
                    <td>${displaySize}</td>
                </tr>
                ` : ""}
            `;
        }

        productCard.innerHTML = `
            <img src="${product.thumbnail || (product.images?.[0]?.image || product.images?.[0]) || 'images/no-image.webp'}" alt="${product.name}">
            <div class="selected-product-content">
                <h2>${product.name}</h2>
                <table class="product-specification">
                    <tr>
                        <th>Category</th>
                        <td>${displayCategory}</td>
                    </tr>
                    <tr>
                        <th>Material</th>
                        <td>${product.material || "-"}</td>
                    </tr>
                    <tr>
                        <th>Shape</th>
                        <td>${product.shape || "-"}</td>
                    </tr>
                    ${dimensionRowsHTML}
                    <tr>
                        <th>Price</th>
                        <td>₹ ${Number(displayPrice || 0).toLocaleString("en-IN")}</td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td>${product.color || "-"}</td>
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
         </div>
        `;
        console.log('Selected', product);
    } catch (err) {
        console.error("Error loading selected product:", err);
    }
    finally {
        hideLoader();
    }
}

loadSelectedProduct();

if (form) {
    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        let isValid = true;
        document.querySelectorAll(".error").forEach(error => {
            error.textContent = "";
        });
        document.querySelectorAll("input, textarea").forEach(field => {
            field.classList.remove("error-input");
            field.classList.remove("valid-input");
        });
        const name = document.getElementById("name");
        const phone = document.getElementById("phone");
        const email = document.getElementById("email");
        const subject = document.getElementById("subject");
        const sourceMenu = document.getElementById("sourceMenu");
        const address = document.getElementById("address");
        const message = document.getElementById("message");

        // Name
        if (name.value.trim() === "") {
            showError(name, "Name is required");
            isValid = false;
        } else {
            showSuccess(name);
        }

        // Phone
        const phoneRegex = /^[6-9]\d{9}$/;
        if (phone.value.trim() === "") {
            showError(phone, "Phone number is required");
            isValid = false;
        } else if (!phoneRegex.test(phone.value.trim())) {
            showError(phone, "Enter a valid 10-digit mobile number");
            isValid = false;
        } else {
            showSuccess(phone);
        }

        // Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value.trim() === "") {
            showError(email, "Email is required");
            isValid = false;
        } else if (!emailRegex.test(email.value.trim())) {
            showError(email, "Enter a valid email address");
            isValid = false;
        } else {
            showSuccess(email);
        }

        // Subject
        if (subject.value.trim() === "") {
            showError(subject, "Subject is required");
            isValid = false;
        } else {
            showSuccess(subject);
        }

        // Message
        if (message.value.trim() === "") {
            showError(message, "Message is required");
            isValid = false;
        } else if (message.value.trim().length < 10) {
            showError(message, "Message should be at least 10 characters");
            isValid = false;
        } else {
            showSuccess(message);
        }

        // Address
        if (address.value.trim() === "") {
            showError(address, "Address is required");
            isValid = false;
        } else if (address.value.trim().length < 10) {
            showError(address, "Address should be at least 10 characters");
            isValid = false;
        } else {
            showSuccess(address);
        }

        // Source
        if (sourceInput.value.trim() === "") {
            if (sourceError) sourceError.textContent = "Please select how you heard about us.";
            if (sourceBtn) sourceBtn.classList.add("error-input");
            isValid = false;
        } else {
            if (sourceError) sourceError.textContent = "";
            if (sourceBtn) {
                sourceBtn.classList.remove("error-input");
                sourceBtn.classList.add("valid-input");
            }
        }

        if (isValid) {

            showLoader();

            const formData = {
                name: name.value.trim(),
                phone: phone.value.trim(),
                email: email.value.trim(),
                subject: subject.value.trim(),
                message: message.value.trim(),
                address: address.value.trim(),
                source: sourceInput.value.trim()
         };

            if (selectedProduct && slug) {
                const hasSizes = selectedProduct.sizes && selectedProduct.sizes.length > 0;
                const catName = getCategoryName(selectedProduct.category);
                const isPlanter = catName.includes('planter');

                const rawImage =
                    selectedProduct.thumbnail ||
                    (selectedProduct.images?.[0]?.image || selectedProduct.images?.[0]) ||
                    "";

                const isLocal =
                    window.location.hostname === "localhost" ||
                    window.location.hostname === "185.27.134.117";

                const absoluteImage = isLocal
                    ? `${window.location.origin}/cai/${rawImage}`
                    : `${window.location.origin}/${rawImage}`;

                console.log(absoluteImage);

                let formattedFeatures = "";
                if (Array.isArray(selectedProduct.features)) {
                    formattedFeatures = selectedProduct.features.join(", ");
                } else if (typeof selectedProduct.features === "string") {
                    formattedFeatures = selectedProduct.features;
                }

                Object.assign(formData, {
                    productName: selectedProduct.name,
                    productCategory: typeof selectedProduct.category === "object" ? selectedProduct.category.name : selectedProduct.category,
                    productMaterial: selectedProduct.material,
                    productShape: selectedProduct.shape,
                    productSize: hasSizes ? selectedProduct.selectedSize : (selectedProduct.size?.size || selectedProduct.size),
                    productPrice: hasSizes ? selectedProduct.selectedPrice : selectedProduct.price,
                    productColor: selectedProduct.color,
                    productFinish: selectedProduct.finish,
                    productFeatures: formattedFeatures,
                    productDescription: selectedProduct.description || "",
                    productImage: absoluteImage
             });

                if (isPlanter && hasSizes) {
                    const currentSizeData = selectedProduct.sizes.find(
                        item => item.size === selectedProduct.selectedSize
                    ) || selectedProduct.sizes[0];

                    if (currentSizeData && currentSizeData.dimensions) {
                        Object.assign(formData, {
                            productLength: `${currentSizeData.dimensions.length?.mm || "-"} mm (${currentSizeData.dimensions.length?.inch || "-"})`,
                            productBreadth: `${currentSizeData.dimensions.breadth?.mm || "-"} mm (${currentSizeData.dimensions.breadth?.inch || "-"})`,
                            productHeight: `${currentSizeData.dimensions.height?.mm || "-"} mm (${currentSizeData.dimensions.height?.inch || "-"})`
                    });
                }
              }
         }

            try {
                const response = await fetch("api/contact.php", {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(formData)
            });
                if (response.ok) {
                    console.log("Form submitted successfully", formData);
                    showToast("Enquiry submitted successfully. We will get back to you soon.", "success");
                    form.reset();

                    // Clear URL params
                    window.history.replaceState({}, document.title, window.location.pathname);

                    // Reset product data
                    selectedProduct = null;
                    selectedSizeData = null;

                    // Reset source dropdown
                    selectedSource.textContent = "Select Source";
                    sourceInput.value = "";
                    sourceBtn.classList.remove("valid-input", "error-input");

                    // Hide selected product
                    productCard.innerHTML = "";
                    productCard.style.display = "none";

                    document.querySelectorAll("input, textarea").forEach(field => {
                        field.classList.remove("valid-input");
                    });

                    if (!slug) {
                        productCard.innerHTML = "";
                    }

            } else {
                    showToast("Something went wrong. Please try again.", "error");
            }
        } catch (error) {
            console.error(error);
            showToast("Unable to submit the form. Please try again later.", "error");
        }
        finally {
            hideLoader();
      }
    }
    });
}

function showError(input, message) {
    if (input === sourceInput) {
        sourceBtn.classList.add("error-input");
        const error = document.getElementById("sourceError");
        if (error) {
            error.textContent = message;
        }
        return;
    }
    input.classList.add("error-input");
    if (input.nextElementSibling) {
        input.nextElementSibling.textContent = message;
    }
}

function showSuccess(input) {
    if (input === sourceInput) {
        sourceBtn.classList.remove("error-input");
        sourceBtn.classList.add("valid-input");
        const error = document.getElementById("sourceError");
        if (error) {
            error.textContent = "";
        }
        return;
    }
    input.classList.add("valid-input");
}

function showToast(message, type = "success") {
    const toast = document.getElementById("toast");
    if (!toast) return;
    toast.className = "show";
    let icon = "";
    switch (type) {
        case "success":
            toast.classList.add("success");
            icon = '<i class="fa-solid fa-circle-check"></i>';
          break;
        case "error":
            toast.classList.add("error");
            icon = '<i class="fa-solid fa-circle-xmark"></i>';
          break;
        case "warning":
            toast.classList.add("warning");
            icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
          break;
        case "info":
            toast.classList.add("info");
            icon = '<i class="fa-solid fa-circle-info"></i>';
          break;
        default:
            toast.classList.add("success");
            icon = '<i class="fa-solid fa-circle-check"></i>';
    }
    toast.innerHTML = `${icon} <span>${message}</span>`;
    clearTimeout(toast.timer);
    toast.timer = setTimeout(() => {
        toast.classList.remove("show");
    }, 5000);
}