<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "db.php";
require_once "config.php";
header("Content-Type: application/json");

function getFallbackValue($value)
{
    return !empty($value) ? $value : "-";
}

function getProductFeaturesHtml($productFeatures)
{
    if (is_string($productFeatures)) {
        $decodedFeatures = json_decode($productFeatures, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $productFeatures = $decodedFeatures;
        } else {
            $productFeatures = array_map('trim', explode(',', $productFeatures));
        }
    }

    if (empty($productFeatures) || !is_array($productFeatures)) {
        return "-";
    }

    $featuresHtml = "<ul style='margin: 0; padding-left: 20px;'>";
    foreach ($productFeatures as $feature) {
        $trimmed = trim($feature);
        if ($trimmed !== "") {
            $featuresHtml .= "<li>" . htmlspecialchars($trimmed, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</li>";
        }
    }
    $featuresHtml .= "</ul>";

    return $featuresHtml === "<ul style='margin: 0; padding-left: 20px;'></ul>" ? "-" : $featuresHtml;
}

function normalizeEmailAddress($email, $fallbackAddress = null)
{
    $candidate = trim((string) $email);
    if ($candidate !== '' && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
        return $candidate;
    }

    if ($fallbackAddress !== null) {
        $fallback = trim((string) $fallbackAddress);
        if ($fallback !== '' && filter_var($fallback, FILTER_VALIDATE_EMAIL)) {
            return $fallback;
        }
    }

    return null;
}

function createMailer()
{
    $senderAddress = normalizeEmailAddress(SMTP_USER, MAIL_OWNER);
    if ($senderAddress === null) {
        throw new Exception('No valid sender email address is configured for the mailer.');
    }

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = $senderAddress;
    $mail->Password = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = SMTP_PORT;
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setFrom($senderAddress, 'Concrete Arts India');
    $mail->isHTML(true);

    return $mail;
}

function createEnquiryDetailsTable($data)
{
    $rows = "";
    $rows .= "<tr>";
    $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b; width: 30%;'>Name</th>";
    $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
    $rows .= "</tr>";
    $rows .= "<tr style='background-color: #f1f5f9;'>";
    $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Phone</th>";
    $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'><a href='tel:" . htmlspecialchars($data['phone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "'>" . htmlspecialchars($data['phone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</a></td>";
    $rows .= "</tr>";
    $rows .= "<tr>";
    $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Email</th>";
    $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
    $rows .= "</tr>";
    $rows .= "<tr style='background-color: #f1f5f9;'>";
    $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Subject</th>";
    $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['subject'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
    $rows .= "</tr>";
    $rows .= "<tr>";
    $rows .= "<th align='left' style='padding:12px;border:1px solid #e2e8f0;color:#64748b;'>Source</th>";
    $rows .= "<td style='padding:12px;border:1px solid #e2e8f0;color:#1e293b;'>" . htmlspecialchars($data['source'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
    $rows .= "</tr>";
    $rows .= "<tr style='background-color:#f1f5f9;'>";
    $rows .= "<th align='left' style='padding:12px;border:1px solid #e2e8f0;color:#64748b;'>Address</th>";
    $rows .= "<td style='padding:12px;border:1px solid #e2e8f0;color:#1e293b;'>" . htmlspecialchars($data['customer_address'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
    $rows .= "</tr>";
    $rows .= "<tr>";
    $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Message</th>";
    $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . nl2br(htmlspecialchars($data['message'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . "</td>";
    $rows .= "</tr>";

    if (!empty($data['productName'])) {
        $rows .= "<tr style='background-color: #f1f5f9;'>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Product Image</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; text-align: center;'>";
        $imageUrl = !empty($data['productImage']) ? $data['productImage'] : '';

        // Force absolute path[cite: 1]
        if (!preg_match('~^(?:f|ht)tps?://~i', $imageUrl) && !empty($imageUrl)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
            $domain = $_SERVER['HTTP_HOST'] ?? 'concreteartsindia.infinityfree.io';
            $imageUrl = $protocol . $domain . '/' . ltrim($imageUrl, '/');
        }

        $rows .= !empty($imageUrl)
            ? "<img src='" . htmlspecialchars($imageUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "' 
                  alt='" . htmlspecialchars($data['productName'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "' 
                  class='product-image'
                  style='display:block; max-width:100%; object-fit:cover;'>"
            : "-";
        $rows .= "</td>";
        $rows .= "</tr>";

        $rows .= "<tr>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Product</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>";
        if (!empty($data['productURL'])) {
            $rows .= htmlspecialchars($data['productName'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        } else {
            $rows .= htmlspecialchars($data['productName'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }
        $rows .= "</td>";
        $rows .= "</tr>";
        $rows .= "<tr style='background-color: #f1f5f9;'>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Category</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productCategory'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
        $rows .= "</tr>";
        $rows .= "<tr>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Material</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productMaterial'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
        $rows .= "</tr>";
        $rows .= "<tr style='background-color: #f1f5f9;'>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Color</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productColor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
        $rows .= "</tr>";
        $rows .= "<tr>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Size</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productSize'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
        $rows .= "</tr>";
        $rows .= "<tr style='background-color: #f1f5f9;'>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Price</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productPrice'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
        $rows .= "</tr>";

        if (!empty($data['productLength']) || !empty($data['productBreadth']) || !empty($data['productHeight'])) {
            $rows .= "<tr>";
            $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Dimensions (L x B x H)</th>";
            $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productLength'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . " x " . htmlspecialchars($data['productBreadth'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . " x " . htmlspecialchars($data['productHeight'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
            $rows .= "</tr>";
        }

        $rows .= "<tr style='background-color: #f1f5f9;'>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Finish</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . htmlspecialchars($data['productFinish'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
        $rows .= "</tr>";
        $rows .= "<tr>";
        $rows .= "<th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Features</th>";
        $rows .= "<td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>" . $data['productFeaturesHtml'] . "</td>";
        $rows .= "</tr>";
    }

    return $rows;
}

function buildEmailBody($headline, $intro, $detailsRows)
{
    return "<div style='font-family: \"Roboto\", Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>" .
        "<div style='background-color: #b8864a; padding: 25px; text-align: center;'>" .
        "<h1 style='color: #ffffff; margin: 0; font-size: 24px;'>Concrete Arts India</h1>" .
        "</div>" .
        "<div style='padding: 30px;'>" .
        "<h2 style='color: #1e293b; margin-top: 0;'>" . $headline . "</h2>" .
        "<p style='color: #475569; line-height: 1.6;'>" . $intro . "</p>" .
        "<h3 style='color: #b8864a; margin-top: 30px; border-bottom: 1px solid #cbd5e1; padding-bottom: 10px;'>Enquiry Details</h3>" .
        "<table style='width: 100%; border-collapse: collapse; margin-top: 15px; background-color: #ffffff;'>" .
        $detailsRows .
        "</table>" .
        "</div>" .
        "<div style='margin-top: 40px; padding: 30px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center; color: #475569;'>" .
        "<p style='margin: 0 0 10px 0; font-weight: 600; font-size: 16px; color: #1e293b;'>Concrete Arts India</p>" .
        "<div style='margin-bottom: 20px;'>" .
        "<a href='mailto:contact.concreteartsindia@gmail.com' style='color: #334155; text-decoration: none; font-size: 14px; margin: 0 10px;'>📧 contact.concreteartsindia@gmail.com</a>" .
        "<span style='color: #cbd5e1;'>|</span>" .
        "<a href='tel:+7506865658' style='color: #334155; text-decoration: none; font-size: 14px; margin: 0 10px;'>📞 +91 75068 65658</a>" .
        "</div>" .
        "<p style='font-size: 12px; margin: 0; color: #94a3b8;'>&copy; " . date('Y') . " Concrete Arts India. All rights reserved.</p>" .
        "<p style='font-size: 11px; margin-top: 10px; color: #1e293b;'>You are receiving this email because you made an enquiry on our website.</p>" .
        "</div>" .
        "</div>";
}

/*=========================================
    ALLOW ONLY POST
=========================================*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method Not Allowed"
    ]);
    exit;
}

/*=========================================
    GET JSON DATA
=========================================*/

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid Request"
    ]);
    exit;
}

/*=========================================
    REQUIRED FIELDS
=========================================*/

$name = trim($data["name"] ?? "");
$phone = trim($data["phone"] ?? "");
$email = trim($data["email"] ?? "");
$subject = trim($data["subject"] ?? "");
$message = trim($data["message"] ?? "");
$customer_address = trim($data["address"] ?? "");
$source = trim($data["source"] ?? "");
if (
    empty($name) ||
    empty($phone) ||
    empty($email)
) {
    echo json_encode([
        "success" => false,
        "message" => "Required fields missing."
    ]);
    exit;
}

/*=========================================
    PRODUCT FIELDS
=========================================*/

$productName = $data["productName"] ?? null;
$productCategory = $data["productCategory"] ?? null;
$productMaterial = $data["productMaterial"] ?? null;
$productSize = $data["productSize"] ?? null;
$productPrice = $data["productPrice"] ?? null;
$productLength = $data["productLength"] ?? null;
$productBreadth = $data["productBreadth"] ?? null;
$productHeight = $data["productHeight"] ?? null;
$productColor = $data["productColor"] ?? null;
$productFinish = $data["productFinish"] ?? null;
$productImage = $data["productImage"] ?? null;
$productURL = $data["productURL"] ?? null;
$productFeatures = $data["productFeatures"] ?? [];

/*=========================================
    INSERT QUERY
=========================================*/

$sql = "
INSERT INTO enquiries (
customer_name,
phone,
email,
subject,
message,
customer_address,
source,
product_name,
product_category,
product_material,
product_size,
product_price,
product_length,
product_breadth,
product_height,
product_color,
product_finish,
product_image,
product_url
)
VALUES (
:customer_name,
:phone,
:email,
:subject,
:message,
:customer_address,
:source,
:product_name,
:product_category,
:product_material,
:product_size,
:product_price,
:product_length,
:product_breadth,
:product_height,
:product_color,
:product_finish,
:product_image,
:product_url
)
";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":customer_name" => $name,
        ":phone" => $phone,
        ":email" => $email,
        ":subject" => $subject,
        ":message" => $message,
        ":customer_address" => $customer_address,
        ":source" => $source,
        ":product_name" => $productName,
        ":product_category" => $productCategory,
        ":product_material" => $productMaterial,
        ":product_size" => $productSize,
        ":product_price" => $productPrice,
        ":product_length" => $productLength,
        ":product_breadth" => $productBreadth,
        ":product_height" => $productHeight,
        ":product_color" => $productColor,
        ":product_finish" => $productFinish,
        ":product_image" => $productImage,
        ":product_url" => $productURL
    ]);
    $displaySource = getFallbackValue($source);
    $displayAddress = getFallbackValue($customer_address);
    $displayMessage = getFallbackValue($message);
    $displaySubject = getFallbackValue($subject);
    $displayProductPrice = !empty($productPrice) ? "₹ " . $productPrice : "-";

    $mailData = [
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'subject' => $displaySubject,
        'message' => $displayMessage,
        'source' => $displaySource,
        'customer_address' => $displayAddress,
        'productName' => $productName ?? "",
        'productCategory' => getFallbackValue($productCategory),
        'productMaterial' => getFallbackValue($productMaterial),
        'productSize' => getFallbackValue($productSize),
        'productPrice' => $displayProductPrice,
        'productLength' => getFallbackValue($productLength),
        'productBreadth' => getFallbackValue($productBreadth),
        'productHeight' => getFallbackValue($productHeight),
        'productColor' => getFallbackValue($productColor),
        'productFinish' => getFallbackValue($productFinish),
        'productImage' => getFallbackValue($productImage),
        'productURL' => getFallbackValue($productURL),
        'productFeaturesHtml' => getProductFeaturesHtml($productFeatures)
    ];

    $detailsRows = createEnquiryDetailsTable($mailData);
    $customerBody = buildEmailBody(
        "Dear " . htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . ",",
        "Thank you for reaching out to us. We have successfully received your enquiry, and our team will review your request and contact you shortly.",
        $detailsRows
    );
    $ownerBody = buildEmailBody(
        "Dear Admin, new enquiry received",
        "A new enquiry has been submitted through the website. Please review the details below and follow up with the customer as needed.",
        $detailsRows
    );

    try {
        $mail = createMailer();
        $customerEmail = normalizeEmailAddress($email, MAIL_OWNER);
        if ($customerEmail === null) {
            throw new Exception('No valid customer email address was provided.');
        }
        $mail->addAddress($customerEmail, $name);
        $mail->addReplyTo($mail->Username, 'Concrete Arts India');
        $mail->Subject = "Thank you for contacting Concrete Arts India";
        $mail->Body = $customerBody;
        $mail->send();

        $ownerMailer = createMailer();
        $ownerAddress = normalizeEmailAddress(MAIL_OWNER, SMTP_USER);
        if ($ownerAddress === null) {
            throw new Exception('No valid owner email address is configured for the mailer.');
        }
        $ownerMailer->addAddress($ownerAddress, 'Concrete Arts India');
        $ownerMailer->addReplyTo($customerEmail, $name);
        $ownerMailer->Subject = "New enquiry received - " . $name;
        $ownerMailer->Body = $ownerBody;
        $ownerMailer->send();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Unable to send enquiry email at the moment. Please try again later.",
            "error" => $e->getMessage()
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Enquiry submitted successfully."
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}