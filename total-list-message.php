<?php 

if(empty($_POST)) {
    header("location:total-list-latest.php");
    return false;
}


include("includes.php");

include("interakt_sync.php");

require_once './vendor/autoload.php';


$searchqry = "";

/* if($_POST['search']) {
    $searchqry = "WHERE contact_name LIKE '%".$_POST['search']."%' OR designation LIKE '%".$_POST['search']."%'";
}

if(isset($_POST['sactive'])) {
    $sactive = "";
    foreach($_POST['sactive'] as $checkbox) {   
        $sactive .= "active LIKE '%".$checkbox."%' OR ";
    }
    if($_POST['search']) {
        $and_or = "OR";
    } else {
        $and_or = "WHERE";
    }
    $searchqry .= "$and_or ". rtrim($sactive, " OR");
} */

$template = $_POST["template"];

if($template == 1) {

    $body_message = "As you are aware the 8th Annual International Conference *SOxNOx - 2023 is scheduled on 24-25 August 2023 at Hyatt Centric - New Delhi*, primarily focusing to involve technologies, solution providers and powe produces under a roof for like-minded discussions during technical session and a gambit of networking opportunities at the parallel International B2B EXPO. \n\nHave you registered for the only platform in India focusing on environmental issues to enhance your learning & business growth strategies?\n\nIf not, we look forward to reserve your seat today by visiting\nhttps://missionenergy.org/soxnox2023/\n\nFor assistance contact HELPLINE ";

} else if($template == 2) {
    $body_message = "This is to notify and remind you that the two day interactive conference and expo *cemCCUS - 2023 is scheduled on 24-25 August 2023 at Hyatt Centric, New Delhi.* The conference shall bring insights on current state and trends of carbon mitigation technologies and strategies in the cement industry organised by Mission Energy Foundation.\n\ncemCCUS - 2023 will unveil the very latest current and emerging technologies from some of the sector leading experts and energy leaders while providing a showcase for innovative models that can capture carbon potential by turning CO2 by-products into profitable applications for cement industry. *The only Expo in India on CCUS* with Special Focus on Cement Industry with its theme Path to Decarbonise the Cement Industry.\n\nReserve your seat by visiting\nhttps://missionenergy.org/ccus/\n\nFor assistance contact HELPLINE ";

} else if($template == 3) {

    $body_message = "Mission Energy Foundation have Religiously and Dedicatedly Given *15 YEARS to the Nation with 13 EVENTS on Coal Gasification*, Creating Forums of Discussion; Exchange of Ideas; Sharing Practical Experiences; Govt. Advocacies & Networking Opportunities to Professionals and Businesses WORLDWIDE.\n\nWe urge your participation in large scale during *GASIFICATION INDIA - 2023* in its 14th Successful Edition of CONFERENCE - EXPO scheduled on *19-20 October 2023, NDMC Convention Centre - New Delhi*.\n\nThis Year Join GASIFICATION INDIA - 2023 to Experience the only CONFERENCE in India, 25+ Technology EXHIBITS, 500+ Worldwide Participants and 60+ Expert Industry SPEAKERS.\n\nReserve your seat by visiting\nhttps://missionenergy.org/gasification2023/\n\nFor assistance contact HELPLINE ";

} else if($template == 4) {

    $body_message = "We expect your attendance at *HYDROGEN TECHNOLOGY EXPO - 2024*, the only exclusive Expo in India dedicated to discussing advanced technologies for the hydrogen and fuel cell industry.\n\n*HYDROGEN TECHNOLOGY EXPO - 2024* shall brings together the entire hydrogen value chain to focus on developing solutions and innovations for low-carbon hydrogen production, efficient storage and distribution as well as applications in a variety of stationary and mobile applications.\n\nWith 60+ Exhibitors, 25+ Speakers and 1,000+ Attendees *HYDROGEN TECHNOLOGY EXPO - 2024* is scheduled on *25 - 26 April 2024, Hyatt Centric - New Delhi*\n\nReserve your seat by visiting\nhttps://missionenergy.org/hydrogen2024/\n\nFor assistance contact HELPLINE ";

} else if($template == 5) {

    $body_message = "Mission Energy Foundation have Religiously and Dedicatedly Given *15 YEARS to the Nation with 12 EVENTS on Waste-to-Energy and Waste Heat Recovery*, Creating Forums of Discussion; Exchange of Ideas; Sharing Practical Experiences; Govt. Advocacies & Networking Opportunities to Professionals and Businesses WORLDWIDE.\n\nWe urge your participation in large scale during *Waste-toEnergy - 2023* in its 9th Sucessful Edition of CONFERENCE - EXPO scheduled on *19-20 October 2023, NDMC Convention Centre - New Delhi*.\n\nLets gather again to discuss key national policies like the SATAT, waste-to-energy, Biofuel, Biogas and Biomass-cofiring that shall helo in reduction of LNG/crude imports, utilization of domestic feedstock, climate change mitigation and enabling India to create newer business opportunities.\n\nReserve your seat by visiting\nhttps://missionenergy.org/w2e2023/\n\nFor assistance contact HELPLINE ";

} else if($template == 6) {

    $body_message = "Join *MissionEnergy CONNECT - the Largest WhatsApp Community* that now has 1700+ industry professionals Interacting, Networking & Sharing Knowledge. Currently, there are 6 industry-specific Sub-Groups like Hydrogen, Gasification, Waste-to-Energy, Fly Ash, Boiler and Thermal Power Plants.\n\nMissionEnergy CONNECT is a special initiative by Mission Energy Foundation that aims to help create Atmabharat Sustainable Energy Sector.\n\nFor assistance contact HELPLINE ";

}

$sid = "";
$token = "";
$client = new Twilio\Rest\Client($sid, $token);


/* store in database start */

include("connection.php");

$send_date = date('d-m-Y');

mysqli_query($conn, "INSERT INTO wp_message_history (body_message, send_date, template_name) values ('$body_message', '$send_date', '$template')");
/* store in database end */

/* $squery = "SELECT * FROM tbl_address_new $searchqry";
$sresult = mysqli_query($conn ,$squery);

while($row = mysqli_fetch_assoc($sresult)) {

    if($row['cell']) {
        $contact_name = trim($row['contact_name']);

        $mobile_no = "whatsapp:".trim($row['cell']);

        $final_body = "*Namaste ".$contact_name."*" . " \n\n".$body_message;
        try {
            $client->messages->create(
                $mobile_no,
                [
                    'from' => 'whatsapp:+13203358022',
                    'body' => $final_body
                ]
            );
        } catch (Exception $e) {
            echo "<br>Error: " . $e->getMessage().'<br>';
        }
    }

} */

if(isset($_POST['contract_data'])) {
    $contract_data = $_POST['contract_data'];

    foreach($contract_data as $key=>$value) {
        if($value) {
            if(is_numeric($key)) {
                $contact_name = "No Name";
            } else {
                $contact_name = trim($key);
            }
            $mobile_no = "whatsapp:".trim($value);
            $final_body = "*Namaste ".$contact_name."*" . " \n\n".$body_message;

            try {
                $client->messages->create(
                    $mobile_no,
                    [
                        'from' => 'whatsapp:+13203358022',
                        'body' => $final_body
                    ]
                );
            } catch (Exception $e) {
                echo "<br>Error: " . $e->getMessage().'<br>';
            }
        }
    }
} else {
    header("location:total-list-latest.php");
    return false;
}

header("location:total-list-latest.php");
