<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "db.php";
require_once "config.php";

header("Content-Type: application/json");


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

    $mail = new PHPMailer(true);

    try {

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
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom(SMTP_USER, 'Concrete Arts India');

        $mail->addAddress($email, $name);

        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);

        $mail->Subject = "New Enquiry - " . $subject;

        $body = "
        <div style='font-family: \"Roboto\", Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
            
            <!-- Header Section -->
            <div style='background-color: #b8864a; padding: 25px; text-align: center;'>
                <h1 style='color: #ffffff; margin: 0; font-size: 24px;'>Concrete Arts India</h1>
            </div>

            <!-- Content Section -->
            <div style='padding: 30px;'>
                <h2 style='color: #1e293b; margin-top: 0;'>Dear {$name},</h2>
                <p style='color: #475569; line-height: 1.6;'>Thank you for reaching out to us. We have successfully received your enquiry, and our team will review your request and contact you shortly.</p>
                
                <h3 style='color: #b8864a; margin-top: 30px; border-bottom: 1px solid #cbd5e1; padding-bottom: 10px;'>Enquiry Details</h3>
                
                <table style='width: 100%; border-collapse: collapse; margin-top: 15px; background-color: #ffffff;'>
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b; width: 30%;'>Name</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$name}</td>
                    </tr>
                    <tr style='background-color: #f1f5f9;'>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Phone</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$phone}</td>
                    </tr>
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Email</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$email}</td>
                    </tr>
                    <tr style='background-color: #f1f5f9;'>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Subject</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$subject}</td>
                    </tr>
                    <tr>
                        <th align='left' style='padding:12px;border:1px solid #e2e8f0;color:#64748b;'>Source</th>
                        <td style='padding:12px;border:1px solid #e2e8f0;color:#1e293b;'>{$source}</td>
                    </tr>
                    <tr style='background-color:#f1f5f9;'>
                        <th align='left' style='padding:12px;border:1px solid #e2e8f0;color:#64748b;'>Address</th>
                        <td style='padding:12px;border:1px solid #e2e8f0;color:#1e293b;'>{$customer_address}</td>
                    </tr>                    
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Message</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$message}</td>
                    </tr>";

        if (!empty($productName)) {
            $body .= "
                    <tr style='background-color: #f1f5f9;'>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Product Image</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; text-align: center;'>
                            <img src='{$productImage}' alt='{$productName}' style='max-width: 100%; height: auto;'>
                        </td>
                    </tr>
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Product</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$productName}</td>
                    </tr>
                    <tr style='background-color: #f1f5f9;'>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Category</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$productCategory}</td>
                    </tr>
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Material</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$productMaterial}</td>
                    </tr>
                    <tr style='background-color: #f1f5f9;'>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Size</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$productSize}</td>
                    </tr>
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Price</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>₹ {$productPrice}</td>
                    </tr>
                    <tr style='background-color: #f1f5f9;'>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Dimensions</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$productLength} x {$productBreadth} x {$productHeight}</td>
                    </tr>
                    <tr>
                        <th align='left' style='padding: 12px; border: 1px solid #e2e8f0; color: #64748b;'>Finish</th>
                        <td style='padding: 12px; border: 1px solid #e2e8f0; color: #1e293b;'>{$productFinish}</td>
                    </tr>";
        }

        $body .= "
        </table>
    </div>

    <!-- Footer -->
    <div style='margin-top: 40px; padding: 30px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center; color: #475569;'>
    
    <p style='margin: 0 0 10px 0; font-weight: 600; font-size: 16px; color: #1e293b;'>Concrete Arts India</p>
    
    <div style='margin-bottom: 20px;'>
        <a href='mailto:concreteartsindia@gmail.com' style='color: #334155; text-decoration: none; font-size: 14px; margin: 0 10px;'>
            📧 concreteartsindia@gmail.com
        </a>
        <span style='color: #cbd5e1;'>|</span>
        <a href='tel:+7506865658' style='color: #334155; text-decoration: none; font-size: 14px; margin: 0 10px;'>
            📞 +91 75068 65658
        </a>
    </div>

    <p style='font-size: 12px; margin: 0; color: #94a3b8;'>
        &copy; " . date('Y') . " Concrete Arts India. All rights reserved.
    </p>
    <p style='font-size: 11px; margin-top: 10px; color: #1e293b;'>
        You are receiving this email because you made an enquiry on our website.
    </p>
</div>
</div>";

        $mail->Body = $body;

        $mail->send();

    } catch (Exception $e) {

        die("Mailer Error: " . $mail->ErrorInfo);

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
