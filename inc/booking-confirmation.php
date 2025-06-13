<?php

/**
 * Booking Confirmation Email
 *
 * @package CamperBooking
 * @author  Robert Ochoa <contacto@robertochoaweb.com>
 * @license GPL-2.0+
 * @link    https://robertochoaweb.com/casos/camper-booking/
 * @return void
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto;">
    <div class="header" style="background: #a8dadc;padding: 40px 10px; text-align: center;">
        <img src="{logo}" alt="Logo" style="max-width: 150px;" />
        <h1>Order Confirmation</h1>
    </div>

    <div class="content" style="padding: 20px;">
        <p>Dear {customer_name},</p>

        <p>Thank you for your order! We're pleased to confirm that we've received your order and it's being processed.</p>

        <h2>Order Details</h2>
        <p><strong>Order Number:</strong> {order_number}</p>
        <p><strong>Order Date:</strong> {order_date}</p>

        <table style="border: 1px solid black; width: 100%; border-collapse: collapse; max-width: 600px; margin: 10px auto 40px;">
            <thead>
                <tr>
                    <th style="background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: left;">Camper</th>
                    <th style="background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: left;">Dates</th>
                    <th style="background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: left;">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{camper}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{dates}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{price}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th style="background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: left;" colspan="2">Subtotal</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{subtotal}</td>
                </tr>
                <tr>
                    <th style="background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: left;" colspan="2">Tax</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">[Tax Amount]</td>
                </tr>
                <tr>
                    <th style="background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: left;" colspan="2">Total</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{total}</td>
                </tr>
            </tfoot>
        </table>

        <h2>Payment Information</h2>
        <p><strong>Payment Method:</strong> {payment_method}</p>

        {instructions}

        <p>If you have any questions about your order, please contact our customer service at {email} or call us at {phone}.</p>

        <p>Sincerely,<br>
            {company_name} Team</p>
    </div>

    <div class="footer" style="background-color: #f8f8f8; padding: 20px; text-align: center; font-size: 12px; border-top: 1px solid #ddd;">
        <p>&copy; {year} {company_name}. All rights reserved.</p>
    </div>
</body>

</html>