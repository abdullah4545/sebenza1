<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} Subscription Invoice !</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        /**
   * Better fluid images in Internet Explorer.
   */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /**
   * Remove blue links for iOS devices.
   */
        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        /**
   * Fix centering issues in Android 4.4.
   */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /**
   * Collapse table borders to avoid space between cells.
   */
        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
    </style>

</head>

<body style="background-color: #e9ecef;">


    <!-- start body -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">

        <!-- start logo -->
        <tr>
            <td align="center" bgcolor="#e9ecef">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 36px 24px;">
                            <a href="{{ env('APP_URL') }}" target="_blank" style="display: inline-block;">
                                <img src="{{ asset(App\Models\Basicinfo::first()->logo) }}" alt="Logo"
                                    border="0" width="150px"
                                    style="display: block; width: 150px; max-width: 150px; min-width: 150px;">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end logo -->

        <!-- start hero -->
        <tr>
            <td align="center" bgcolor="#e9ecef">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                            <h1
                                style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">
                                Dear {{ $details['user']['first_name'] }} {{ $details['user']['last_name'] }}</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end hero -->

        <!-- start copy block -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">We hope this email finds you well. We are delighted to present your
                                invoice from Sebenza, your all-in-one
                                business management platform. This invoice is a detailed summary of the services and
                                products you have availed
                                from us during the specified period.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">
                                Invoice Number: {{ $details['invoice']['invoiceID'] }}
                                <br>
                                Invoice Date: {{ $details['invoice']['invoiceDate'] }}
                                <br>
                                Total Amount: {{ $details['invoice']['payable_amount'] }}
                                <br>Payment Method: [Payment Method]
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">To make the payment process smooth and hassle-free, we have provided a
                                secure link below. Please use this link to
                                proceed with the payment.</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" bgcolor="#ffffff">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                                    <a href="{{ url(env('APP_URL')) }}" target="_blank"
                                                        style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                                        Payment Link
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">If you have any questions or concerns regarding the invoice or need
                                any further assistance, please do not
                                hesitate to contact us. Our team is always available to support and provide the
                                necessary guidance.</p>

                        </td>
                    </tr>
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;"> We greatly appreciate your continued partnership with Sebenza and
                                look forward to serving you in the future.
                                Your satisfaction is our priority, and we are committed to providing exceptional service
                                at all times.</p>

                        </td>
                    </tr>
                    <!-- end copy -->

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff"
                            style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                            <p>Thank you for choosing Sebenza as your trusted business solution.</p>
                            <p style="margin: 0;">Best regards,<br>
                                <b>{{ env('APP_NAME') }} Platform</b>
                                <br>Email: {{ App\Models\Basicinfo::first()->email }}<br>
                                Website: {{ env('APP_URL') }}
                            </p>

                        </td>
                    </tr>
                    <!-- end copy -->

                </table>
            </td>
        </tr>
        <!-- end copy block -->



    </table>
    <!-- end body -->

</body>

</html>
