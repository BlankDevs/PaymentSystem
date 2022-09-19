<?php
/**
 * @param array $data
 * @param null $passPhrase
 * @return string
 */
function generateSignature($data, $passPhrase = null) {
    // Create parameter string
    $pfOutput = '';
    foreach( $data as $key => $val ) {
        if($val !== '') {
            $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
        }
    }
    // Remove last ampersand
    $getString = substr( $pfOutput, 0, -1 );
    if( $passPhrase !== null ) {
        $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
    }
    return md5( $getString );
}


// Construct variables
$cartTotal = 100.00; // This amount needs to be sourced from your application
$passphrase = 'BlankDevsCode'; //jt7NOE43FZPn
$data = array(
    // Merchant details
    'merchant_id' => '10027301',
    'merchant_key' => 'ket2n86f94o9a',
    'return_url' => 'https://blankdevs.co.za/return.html', // php files for integration
    'cancel_url' => 'https://blankdevs.co.za/cancel.html',
    'notify_url' => 'https://blankdevs.co.za/notify.php',
    // Buyer details
    'name_first' => 'Blank Devs',
    'name_last'  => 'eKasiVR',
    'email_address'=> 'test@test.com',
    // Transaction details
    'm_payment_id' => '#0001', //Unique payment ID to pass through to notify_url
    'amount' => number_format( sprintf( '%.2f', $cartTotal ), 2, '.', '' ),
    'item_name' => 'VR Glasses'
);

$signature = generateSignature($data, $passphrase);
$data['signature'] = $signature;

// If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
$testingMode = true;
$pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
$htmlForm = '<form action="https://'.$pfHost.'/eng/process" method="post">';
foreach($data as $name=> $value)
{
    $htmlForm .= '<input name="'.$name.'" type="hidden" value=\''.$value.'\' />';
}
$htmlForm .= '<input type="submit" value="proceed to checkout" class="submit-btn"></form>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">
   
    <?php echo $htmlForm; ?>

</div>    
    
</body>
</html>