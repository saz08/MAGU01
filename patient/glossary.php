<?php

session_start();
function safePOST($conn,$name){
    if (isset($_POST[$name])) {
        return $conn->real_escape_string(strip_tags($_POST[$name]));
    } else {
        return "";
    }
}
function safePOSTNonMySQL($name){
    if(isset($_POST[$name])){
        return strip_tags($_POST[$name]);
    }
    else{
        return "";
    }
}

//connect to the database now that we know we have enough to submit
$host = "devweb2018.cis.strath.ac.uk";
$user = "szb15123";
$pass = "fadooCha4buh";
$dbname = "szb15123";
$conn = new mysqli($host, $user, $pass , $dbname);
$action = safePOST($conn, "action");

$month = date("m");
$year = date("Y");

if(isset($_SESSION["sessionuser"])){
    $user = $_SESSION["sessionuser"];
    $sessionuser = $_SESSION["sessionuser"];
}

else{
    $sessionuser ="";
    $user = safePOSTNonMySQL("username");
    $pass = safePOSTNonMySQL("password");
}

if($_SESSION['userName']==null){
    $_SESSION['userName'] = "unknownUser";
    ?> <script>
        localStorage.setItem('username', "unknownUser");
        localStorage.setItem('loginOK', "no");
    </script><?php
}

$username = $_SESSION["userName"];
//$username= "<script>localStorage.getItem('username')</script>";




$loginOK = false; //TODO make this work with database values

if($loginOK) {
    if (!isset($_SESSION["sessionuser"])) {
        session_regenerate_id();
        $_SESSION["sessionuser"] = $user;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/collapsible.css">

    <meta charset="UTF-8">
    <title>Information</title>
<style>


    #myInput {
        background-image: url('/css/searchicon.png');
        background-position: 10px 12px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

     #myli a {
        border: 1px solid #ddd;
        margin-top: -1px; /* Prevent double borders */
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        color: black;
        display: block
    }

     #myli a:hover:not(.header) {
        background-color: #eee;
    }
</style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#myPage">    </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-left">
                <li><a href="index.php">HOME</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">RECORD <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="scale.php">HEALTH MONITORING</a></li>
                        <li><a href="weight.php">WEIGHT MONITORING</a></li>
                        <li><a href="physical.php">PHYSICAL ACTIVITY MONITORING</a></li>
                    </ul>
                </li>                  <li><a href="talk.php">TALK</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="helpInfo.php">INFO</a></li>
                        <li><a href="helpFinancial.php">FINANCIAL</a></li>
                        <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                        <li><a href="helpPhysical.php">PHYSICAL</a></li>
                    </ul>
                </li>                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PROFILE <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="statusChart.php">STATUS CHARTS</a></li>
                        <li><a href="weightChart.php">WEIGHT CHART</a></li>
                        <li><a href="physicalChart.php">PHYSICAL ACTIVITY CHART</a></li>
                        <li><a href="questions.php">QUESTIONS</a></li>
                        <li><a href="supportCircle.php">SUPPORT CIRCLE</a></li>

                    </ul>
                </li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>Lung Cancer Alliance Glossary <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search a keyword.." title="Start typing">
<div id="x" class="box">
    <h1>A</h1>
    <br>
    <br>
    <ul id="myUL">
        <li id="myli">
            Acute:
            Sudden onset of symptoms or disease.
        </li>
        <li id="myli">
            Adenocarcinoma:
            A type of non-small cell lung cancer that begins in the cells that form the lining of the lungs and has gland-like properties.
        </li>
        <li id="myli">
            Adjuvant Therapy:
            A treatment used in addition to primary therapy to increase effectiveness of treatment; for example, adjuvant chemotherapy following surgery.
        </li>
        <li id="myli">
            Adverse Reaction:
            An unintended or unexpected negative reaction to treatment; for example, low blood counts.
        </li>
        <li id="myli">
            Alopecia:
            Hair loss, a side effect of some cancer treatments.
        </li>
        <li id="myli">
            Alveoli:
            Tiny balloon-like sacs in the lungs where oxygen, carbon dioxide, and other substances are exchanged between the lungs and bloodstream.
        </li>
        <li id="myli">
            Alveolus:
            Plural of Alveoli.
        </li>
        <li id="myli">
            Analgesic:
            A drug that relieves pain.
        </li>
        <li id="myli">
            Anemia:
            A decrease in the number of red blood cells; anemia be a result of the cancer itself or from the treatments; symptoms include fatigue and shortness of breath.
        </li>
        <li id="myli">
            Anesthesia:
            Drugs that control pain during surgery and other procedures.
        </li>
        <li id="myli">
            Angiogenesis:
            The process in which cancer cells develop new blood vessels that supply them with oxygen and nutrients, which allow them to grow; treatment designed to stop this process and to starve the cells to slow or stop growth is called anti-angiogenesis therapy.
        </li>
        <li id="myli">
            Anorexia:
            Loss of appetite or strong lack of interest in food, a result of the cancer itself, from treatments, or from emotional reaction to the diagnosis.
        </li>
        <li id="myli">
            Antibiotic:
            A drug that kills or reduces the growth of bacteria.
        </li>
        <li id="myli">
            Anti-angiogenesis Therapy:
            Drugs that prevent the development of new blood vessels supplying a tumor with nutrients it needs to survive, thereby killing the tumor.
        </li>
        <li id="myli">
            Antibody Therapy:
            Treatment designed to induce an immune response against cancer cells; antibodies that recognize antigens (substances on cancer cells) have been developed to induce this immune response.
        </li>
        <li id="myli">
            Antibody:
            A protein in the immune system that identifies and destroys foreign substances such as bacteria and viruses.
        </li>
        <li id="myli">
            Antiemetics:
            Drugs that reduce or prevent nausea and vomiting.
        </li>
        <li id="myli">
            Atelectasis:
            Collapsed lung; failure of lung to inflate properly.
        </li>
        <li id="myli">
            Asymptomatic:
            Without obvious signs or symptoms of disease.
        </li>
        <li id="myli">
            Atypical:
            Abnormal or not usual.
        </li>

        <h1>B</h1>
        <br>
        <br>
        <li id="myli">
            Benign:
            Not cancer (see also Malignant).
        </li>
        <li id="myli">
            Biomarkers (molecule marker, signature molecule):
            A biological molecule (the basis for all human cells), found in blood or other bodily fluids or tissue, which is a sign of normal or abnormal process or of a condition or disease.
        </li>
        <li id="myli">
            Biopsy:
            The removal and examination of tissue or fluid, used to confirm the presence of cancer and to determine the type of lung cancer.
        </li>
        <li id="myli">
            Blood Cell:
            The cells of the blood; there are two types, white blood cells, red blood cells (see also Platelets).
        </li>
        <li id="myli">
            Blood Count or Complete Blood Count (CBC):
            A test that examines the amounts of different parts of the blood, such as white blood cells, red blood cells, platelets and hemoglobin.
        </li>
        <li id="myli">
            Bone Scan:
            A type of scan used to determine if cancer has spread to the bones.
        </li>
        <li id="myli">
            Brachytherapy Radiation:
            A cancer treatment in which radioactive material sealed in needles, seeds, wires or catheters is placed directly into or near the tumor.
        </li>
        <li id="myli">
            Bronchi:
            Plural of bronchus, used when referring to both the air tubes.
        </li>
        <li id="myli">
            Bronchiogenic Carcinoma:
            Another name for lung cancer.
        </li>
        <li id="myli">
            Bronchioaveloar Carcinoma (BAC):
            A rare subtype of adenocarcinoma that begins in the alveoli.
        </li>
        <li id="myli">
            Bronchioles:
            The very small tubes that lead into the alveolus.
        </li>
        <li id="myli">
            Bronchoscope:
            A thin, usually flexible lighted tube used during a bronchoscopy.
        </li>
        <li id="myli">
            Bronchoscopy:
            A procedure in which a bronchoscope is inserted through the nose or mouth, into the lungs, which allow the doctor to look directly into the airways and lungs. A needle inserted into the bronchoscope can be used to obtain samples of the tumor or fluid for biopsy testing.
        </li>
        <li id="myli">
            Bronchus:
            One of the two main breathing tubes branching off from the windpipe; one bronchus leads into each lung.
        </li>

        <h1>C</h1>
        <br>
        <br>
        <li id="myli">
            Cachexia:
            Loss of body weight and muscle mass, leading to weakness that may occur in patients with cancer; most often seen in patients with advanced cancer.
        </li>
        <li id="myli">
            Cancer:
            A disease characterized by cells that change, grow and divide in an out of control manner, and then interfere with the body’s normal functioning.
        </li>
        <li id="myli">
            Cancer Cell:
            A cell that divides and reproduces abnormally.
        </li>
        <li id="myli">
            Carcinoma in Situ:
            Earliest stage cancer in which the disease is confined to the original cells or tissue in which it started.
        </li>
        <li id="myli">
            Carcinogen:
            A substance that causes cancer; something that is carcinogenic is cancer causing.
        </li>
        <li id="myli">
            Carcinogenesis:
            The process by which cancer develops.
        </li>
        <li id="myli">
            Carcinoma:
            A form of cancer that develops in tissues covering the external or internal surfaces.
        </li>
        <li id="myli">
            Capillaries:
            Tiny blood vessels.
        </li>
        <li id="myli">
            Cell:
            The basic building block of all living tissues; comprised of a nucleus (the “brain” of the cell), the cytoplasm surrounding the nucleus, and a cell wall.
        </li>
        <li id="myli">
            Centimeters (cm):
            A measure of length in the metric system; 3 cm is just over an inch; 5 cm is nearly 2 inches; 7 cm is 2 ¾ inches.
        </li>
        <li id="myli">
            Central Nervous System (CNS):
            The control center for the body; includes the spinal cord and the brain.
        </li>
        <li id="myli">
            Chemoprevention:
            The use of chemicals, vitamins, or minerals to prevent cancer.
        </li>
        <li id="myli">
            Chemosensitizer:
            A drug which makes tumor cells more sensitive to the effects of chemotherapy drugs.
        </li>
        <li id="myli">
            Chemotherapy:
            A drug or combination of drugs used to fight cancer.
        </li>
        <li id="myli">
            Chromosome:
            A strand of DNA and related proteins that carries the genes and transmits hereditary information.
        </li>
        <li id="myli">
            Chronic:
            Lasting for a long period of time or marked by frequent recurrence.
        </li>
        <li id="myli">
            Cilia:
            Tiny, hair-like projections located on cells; in the lungs, they clean by sweeping out mucus containing contains dust, germs, etc.
        </li>
        <li id="myli">
            Clinical Trials:
            Studies that evaluate new treatments or possible improvements in current treatments.
        </li>
        <li id="myli">
            Combination Chemotherapy:
            A treatment that uses two or more anti-cancer medications.
        </li>
        <li id="myli">
            Combined Modality Therapy:
            The use of two or more types of treatment; may include combinations of radiation, chemotherapy, surgery, or others.
        </li>
        <li id="myli">
            Complementary and Alternative Medicine (CAM):
            Complementary medicine is the use of techniques or approaches used in addition to standard treatment, such as meditation or diet (also called integrative medicine or treatment); alternative medicine refers to treatment outside standard therapies that have not been proven by clinical trial to be effective.
        </li>
        <li id="myli">
            Complete Blood Count (CBC) – see Blood Count Complete Response, Complete Remission:
            The disappearance of all cancer in response to treatment.
        </li>
        <li id="myli">
            Complications:
            Unexpected symptoms or problems resulting from medical treatment.
        </li>
        <li id="myli">
            Computed Tomography Scan (CT or CAT Scan):
            An imaging test that can detect extremely small tumors and helps doctors understand more about the tumor and if it has spread.
        </li>
        <li id="myli">
            Consolidation therapy:
            Treatment given to further treat the cancer with the goal of complete remission.
        </li>
        <li id="myli">
            Contralateral:
            On the opposite side of the body; in lung cancer this term is generally used to refer to cancer in the lung or lymph nodes opposite that of the primary tumor (see also Ipsilateral).
        </li>
        <li id="myli">
            Counselor:
            A professional who helps in coping with life issues such as emotional or social difficulties.
        </li>
        <li id="myli">
            Cytology:
            The study of cells, their origin, structure, function and pathology.
        </li>
        <h1>D</h1>
        <br>
        <br>
        <li id="myli">
            DNA (deoxyribonucleic acid):
            The part of the cell that contains and controls genetic instructions used in the functioning of the cell.
        </li>
        <li id="myli">
            Diagnosis:
            The process of identifying a disease by its characteristic signs, symptoms, and through tests.
        </li>
        <li id="myli">
            Diagnostic Procedure:
            A method used to identify a disease.
        </li>
        <li id="myli">
            Diaphragm:
            The muscle below the lungs and heart that separates the chest from the abdomen and assists with breathing.
        </li>
        <li id="myli">
            Differentiation:
            The degree to which tumor tissue resembles normal tissue; differentiated cells resemble normal cells and tend to grow and spread at a slower rate than undifferentiated or poorly differentiated cells.
        </li>
        <li id="myli">
            Double-Blinded:
            A type of clinical trial in which neither the medical staff nor the patient knows if the patient is receiving the investigational drug or drug combination.
        </li>
        <li id="myli">
            Drug Resistance:
            The failure of cells to respond to treatments; this can happen at the beginning of treatment or after exposure to the drug.
        </li>
        <li id="myli">
            Dysphagia:
            Difficulty or pain in swallowing.
        </li>
        <li id="myli">
            Dyspnea:
            Shortness of breath.
        </li>
        <h1>E</h1>
        <br>
        <br>
        <li id="myli">
            Edema:
            The swelling of a body part caused by an abnormal build-up of fluids.
        </li>
        <li id="myli">
            Emphysema:
            A disorder which results in the inability of the lungs to exchange oxygen for carbon dioxide and other gases, making it difficult to breathe.
        </li>
        <li id="myli">
            Epidermal Growth Factor Receptors (EGFR):
            A protein receptor that exists on cell surfaces and controls a number of cell activities such as growth and division; certain mutations of this protein can lead to a malfunction of EGFR and cause cancerous cells to multiply rapidly.
        </li>
        <li id="myli">
            Epidermal Growth Factor Receptor (EGFR) Inhibitor:
            A drug designed to prevent protein mutations in EGFR from rapidly multiplying.
        </li>
        <li id="myli">
            Esophagus:
            The tube through which food travels from the mouth into the stomach.
        </li>
        <li id="myli">
            Excision:
            Removal, usually by surgery.
        </li>
        <li id="myli">
            Expectorant:
            A medicine that helps a person cough up secretions from the lungs.
        </li>
        <li id="myli">
            Extensive Stage Small Cell Lung Cancer:
            One of the two ways small cell lung cancer is staged; indicates the cancer is in both lungs or has spread to other parts of the body.
        </li>
        <h1>F</h1>
        <br>
        <br>
        <li id="myli">
            Fatigue:
            Constant and extreme tiredness.
        </li>
        <li id="myli">
            Fibrosis:
            Scarring of the lung; may occur due to treatment and/or disease.
        </li>
        <li id="myli">
            First Line Treatment:
            First therapy given after the diagnosis of cancer.
        </li>
        <li id="myli">
            Food and Drug Administration (FDA):
            The governmental agency that reviews and approves all clinical trials for drugs and other procedures that might prevent or treat cancer as well as other diseases.
        </li>
        <li id="myli">
            Fractionation:
            The division of a total dose of radiation into several smaller, equal doses delivered over a period of several days.
        </li>
            <h1>G</h1>
            <br>
            <br>
        <li id="myli">
            Gene:
            The functional and physical unit of heredity passed from parent to offspring. Genes are pieces of DNA, most contain the information for making a specific protein.
        </li>
        <li id="myli">
            Gene Therapy:
            A treatment that replaces an abnormal gene in a cancer cell with a normal gene.
        </li>
        <li id="myli">
            Genome:
            The complete genetic information of a species.
        </li>
        <li id="myli">
            Grade:
            A method of classifying a tumor of the basis of how aggressively it is growing.
        </li>
        <li id="myli">
            Growth Factor:
            A protein that promotes cell production.
        </li>
        <li id="myli">
            Growth Factor Receptor:
            A protein found on the surface of a cell that binds to a growth factor; growth factor receptors in lung cancer include epidermal growth factor receptors (EGFR) and vascular endothelial growth factor (VEGF).
        </li>
        <h1>H</h1>
        <br>
        <br>
        <li id="myli">
            Hematology:
            The study of blood, blood-producing organs, and blood disorders.
        </li>
        <li id="myli">
            Hemoglobin:
            The iron protein component in the red blood cells that carries oxygen to body tissues.
        </li>
        <li id="myli">
            Hemoptysis:
            Coughing or spitting up blood.
        </li>
        <li id="myli">
            Heredity:
            The transmission of information from parent to offspring through genes.
        </li>
        <li id="myli">
            High Risk:
            When the chance of developing cancer is greater than normally seen in a population.
        </li>
        <li id="myli">
            Hospice:
            End-of-life care that focuses on pain control and comfort rather than treatment of the disease; generally available when the person has six months or less to live.
        </li>
        <li id="myli">
            Hyperalimentation:
            Nutritional support given through a vein.
        </li>
        <li id="myli">
            Hypercalcemia:
            Abnormally high concentrations of calcium in the blood.
        </li>
        <li id="myli">
            Hyperfractional Radiation:
            A division of the total daily dose of radiation into smaller doses that are given more than once a day.
        </li>

        <h1>I</h1>
        <br>
        <br>

        <li id="myli">
            Imaging:
            Procedures that produce pictures of areas inside the body; includes x-ray, CT and PET scans and MRIs.
        </li>
        <li id="myli">
            Immune System:
            The system within the body that recognizes and fights foreign cells and disease.
        </li>
        <li id="myli">
            Immunology:
            The study of the body’s natural defense mechanisms against disease.
        </li>
        <li id="myli">
            Immunotherapy:
            The treatment of disease by inducing, enhancing, or suppressing an immune response.
        </li>
        <li id="myli">
            Induction Therapy:
            Often the first step in treating more advanced lung cancer. May be followed by consolidation treatment and/or maintenance therapy.
        </li>
        <li id="myli">
            Incidence:
            The number of new cases of a specific disease in a defined population during a set period of time.
        </li>
        <li id="myli">
            Incision:
            A cut, usually in reference to surgery.
        </li>
        <li id="myli">
            Infection:
            When harmful and disease-producing germs and organisms enter the body.
        </li>
        <li id="myli">
            Informed Consent:
            A legally required procedure to make sure patients understand potential risks and benefits of a treatment before it is started.
        </li>
        <li id="myli">
            Infusion:
            The administration of fluids or medications into the blood through the veins.
        </li>
        <li id="myli">
            Injection:
            The use of a syringe and needle to deliver medications to the body; a shot.
        </li>
        <li id="myli">
            Intensity Modulated Radiation Therapy (IMRT):
            A type radiation treatment that uses computer-generated images to show the size and shape of the tumor and helps reduce damage to healthy tissues near the tumor.
        </li>
        <li id="myli">
            Intravenous:
            Through a vein, as opposed to intramuscular (through the muscle).
        </li>
        <li id="myli">
            Invasive Cancer:
            Cancer that has spread beyond its site of origin and is growing into surrounding, healthy tissues
        </li>
        <li id="myli">
            Ipsilateral:
            On the same side of the body; in lung cancer this term is generally used to refer to cancer in another lobe or lymph nodes in the lung on the same side of the primary tumor (see also Contralateral)
        </li>
            <h1>L</h1>
            <br>
            <br>
        <li id="myli">
            Large Cell Carcinoma:
            A subtype of non-small cell lung cancer; cells are large and poorly differentiated meaning they have none of the features that would allow it to be diagnosed as another type of non-small cell lung cancer.
        </li>
        <li id="myli">
            Larynx:
            The voice box; located above the windpipe.
        </li>
        <li id="myli">
            Limited Stage Small Cell Lung Cancer:
            One of the two ways small cell lung cancer is staged; indicates that the cancer has not spread beyond one lung, the tissues between the lungs and/or nearby lymph nodes.
        </li>
        <li id="myli">
            Living Will:
            A legal document explaining a person’s desires regarding the use of life sustaining equipment and treatments.
        </li>
        <li id="myli">
            Lobe:
            Section of a lung; there are two lobes in the left lung and three lobes in the right lung.
        </li>
        <li id="myli">
            Lobectomy:
            The surgical removal of one lobe of a lung.
        </li>
        <li id="myli">
            Localized Cancer:
            A cancer confined to the site of origin, usually the organ where it began.
        </li>
        <li id="myli">
            Locally Advanced Cancer:
            Cancer that has spread only to nearby tissues or lymph nodes.
        </li>
        <li id="myli">
            Lung Metastases:
            Not primary lung cancer; tumor cells that have spread from the original tumor to the lung.
        </li>
        <li id="myli">
            Lymph Fluid:
            An almost colorless fluid that travels through the lymph system to help fight infection and disease.
        </li>
        <li id="myli">
            Lymph Node:
            Part of the lymph system, a small bean shaped gland that filters bacteria and other foreign substances.
        </li>
        <li id="myli">
            Lymph Vessel:
            Similar to blood vessels, help to circulate lymph fluid throughout the body.
        </li>
        <li id="myli">
            Lymphatic (Lymph) System:
            A collection of fluid, vessels, and nodes that are found throughout the body; one of the way lung cancer spreads to other parts of the body is through the lymph system.
        </li>

        <h1>M</h1>
        <br>
        <br>
        <li id="myli">
            Magnetic Resonance Imaging (MRI):
            A type of imaging scan that uses magnetic fields to create clear images of body parts, including tissues, muscles, nerves, and bones and show the presence of tumors.
        </li>
        <li id="myli">
            Maintenance Therapy:
            A treatment used to maintain remission and prevent a recurrence
        </li>
        <li id="myli">
            Malignant:
            Also called cancerous; cells that exhibit rapid, uncontrolled growth and can spread to other parts of the body (see also Benign).
        </li>
        <li id="myli">
            Mesothelioma:
            A type of cancer of the lining of organs and not only can originate in the lungs but also the abdomen, heart, and chest; associated with exposure to asbestos.
        </li>
        <li id="myli">
            Mass:
            A growth that may or may not be cancerous.
        </li>
        <li id="myli">
            Measurable Disease:
            An accurate measurement of a tumor’s size; changes in measurable disease indicate a response (or lack of response) to treatment.
        </li>
        <li id="myli">
            Mediastinoscopy:
            A surgical procedure for examining the lymph nodes and area in the middle of the chest (mediastinum).
        </li>
        <li id="myli">
            Mediastinum:
            The area in the middle of the chest behind the breastbone and in front of the heart; organs in this area include the heart, windpipe, esophagus, bronchi, mediastinal lymph nodes.
        </li>
        <li id="myli">
            Metaplasia:
            A change in cells from normal to abnormal.
        </li>
        <li id="myli">
            Metastasis:
            The spread of cancer cells from the original site to other parts of the body; the pleural of metastasis is metastases.
        </li>
        <li id="myli">
            Metastatic Cancer:
            Cancer that has spread from one part of the body to another.
        </li>
        <li id="myli">
            Microscope:
            An instrument that gives an enlarged view of an object.
        </li>
        <li id="myli">
            Microscopic:
            Too small to be seen without a microscope.
        </li>
        <li id="myli">
            Monoclonal Antibody:
            Proteins that attach to substances called receptors on the surface of the cell and block signals that tell the cell what to do; can be used alone to target defects in cancer cells or to make the cells more receptive to the body’s immune system; also used to carry drugs or other substances directly to a cancer tumor.
        </li>
        <li id="myli">
            Mucositis:
            The inflammation of mucus membranes (for example, the mouth) that causes pain, soreness, and/or excessive mucus production.
        </li>
        <li id="myli">
            Multi-Modality Therapy:
            A therapy that combines more than one method of treatment such as chemotherapy and radiation
        </li>
        li id="myli"
            Mutation:
            Change in the DNA of a cell; caused by mistakes during cell division, or exposure to DNA-damaging agents in the environment.
        </li>
        li id="myli"
            Myelosuppression:
            A reduction in the ability of bone marrow to produce blood cells.
        </li>

        <h1>N</h1>
        <br>
        <br>
        li id="myli"
            National Cancer Institute (NCI):
            A governmental agency that is part of the National Institute of Health (NIH); conducts research on cancer and helps to set national policy regarding cancer.
        </li>
        li id="myli"
            Nausea:
            A feeling of sickness or discomfort in the stomach that may come with an urge to vomit.
        </li>
        li id="myli"
            Needle Aspiration or Needle Biopsy:
            A procedure in which a hollow needle is inserted through the skin to draw out tissue or fluid for testing.
        </li>
        li id="myli"
            Neo-Adjuvant Therapy:
            A therapy given before the main treatment to improve the effectiveness of the primary treatment, usually chemotherapy and/or radiation therapy given before surgery.
        </li>
        li id="myli"
            Neoplasm:
            Abnormal mass of tissue, may be benign or cancerous.
        </li>
        li id="myli"
            Neurological:
            Involving the nerves or nervous system.
        </li>
        li id="myli"
            Neuropathy:
            A problem of the which causes numbness, tingling, weakness, or burning in the arms, hands, feet, and/or legs; a side-effect of some chemotherapy.
        </li>
        li id="myli"
            Neutropenia:
            A low number of white blood cells.
        </li>
        li id="myli"
            Neutrophil:
            A type of white blood cell that attacks bacteria.
        </li>
        li id="myli"
            No Evidence of Disease (NED):
            Any disease, if present, is not detectable by imaging tests.
        </li>
        li id="myli"
            Nodule:
            A small solid mass; may be benign or cancerous.
        </li>
        li id="myli"
            Non Small Cell Lung Cancer:
            One of the two main types of lung cancer; includes subtypes, most common of which are adenocarcinoma, squamous cell, and large cell carcinoma.
        </li>

        <h1>O</h1>
        <br>
        <br>
        li id="myli"
            Observation:
            Watching the patient and offering treatment only when symptoms increase or change.
        </li>
        li id="myli"
            Oncologist:
            A physician who specializes in the study, diagnosis, and treatment of cancer.
        </li>
        li id="myli"
            Oncology:
            The study of the development, diagnosis, treatment, and prevention of cancer.
        </li>


        <h1>P</h1>
        <br>
        <br>
        li id="myli"

            Palliative Treatment:
            Treatments designed to reduce the symptoms of a disease or side effects of treatment.
        </li>
        li id="myli"
            Pancoast Tumor (Superior Sulcus Tumor):
            A tumor occurring near the top of the lung; may cause shoulder pain and weakness or another group of symptoms including droopy eyelids, dry eyes, and lack of sweating on the face.
        </li>
        li id="myli"
            Partial Response:
            Indicates that tumors have shrunk, but not completely disappeared as a result of therapy.
        </li>
        li id="myli"
            Pathology:
            The study of the nature of disease and its causes, processes, development, and consequences.
        </li>
        li id="myli"
            Pathologist:
            A physician trained to examine and evaluate cells and tissues.
        </li>
        li id="myli"
            Pericardial Effusion:
            The accumulation of fluid inside the sac (pericardium) surrounding the heart.
        </li>
        li id="myli"
            Phase I Trial:
            A clinical study designed to evaluate the safety and dosage of a new drug or treatment.
        </li>
        li id="myli"
            Phase II Trial:
            A clinical study designed to continue testing the safety of a new drug and to begin to evaluate how well it works.
        </li>
        li id="myli"
            Phase III Trial:
            A clinical study designed to confirm the effectiveness of the study drug or treatment and compare it to the current standard of care.
        </li>
        li id="myli"
            Photodynamic Therapy (PDT):
            The use of a drug called a photosensitizer and a laser light to kill cancer cells; approved to treat lung cancer to reduce obstructions and as a palliative treatment.
        </li>
        li id="myli"
            Placebo:
            An inactive substance or treatment that looks the same and is given in the same way as an active drug or treatment being tested.
        </li>
        li id="myli"
            Plasma:
            Liquid part of the blood, lymph, and intracellular fluid in which cells are suspended.
        </li>
        li id="myli"
            Plasma Cell:
            An antibody producing cell found in lymphoid tissue.
        </li>
        li id="myli"
            Platelet (Thrombocyte):
            Cell fragments (cells with no DNA) in the blood which cause clotting and help to control bleeding.
        </li>
        li id="myli"
            Platelet Count:
            The measurement of the number of platelets in the blood.
        </li>
        li id="myli"
            Pleura:
            Two thin membranes that surround the lung and line the chest cavity and protects and cushions the lung; the space between is called the pleural space, which contains fluid.
        </li>
        li id="myli"
            Pleural Effusion:
            The collection of excess fluid in the pleural space.
        </li>
        li id="myli"
            Pleurodesis:
            A procedure that prevents recurrence of pleural effusion by draining the fluid and sticking the membranes of the pleural space together.
        </li>
        li id="myli"
            Pneumonectomy:
            The surgical removal of one lung.
        </li>
        li id="myli"
            Pneumonia:
            A respiratory condition that involves inflammation of the lung.
        </li>
        li id="myli"
            Poorly Differentiated Cells:
            Lack the structure and function of normal cells and grow uncontrollably; poorly differentiated cells grow faster than differentiated ones but not as fast as those that are undifferentiated.
        </li>
        li id="myli"
            Port:
            Used to deliver chemotherapy, ports are placed and left in the skin to protect the veins and prevent repeated needle sticks.
        </li>
        li id="myli"
            Positron Emission Tomography (PET Scan):
            A type of imaging scan that is used to tell if lung cancer has spread to other parts of the body.
        </li>
        li id="myli"
            Precancerous/Premalignant:
            An early cellular change that may develop into cancer.
        </li>
        li id="myli"
            Primary Tumor:
            The original tumor, at the site the cancer began.
        </li>
        li id="myli"
            Prognosis:
            A prediction of the probable course and outcome of a disease; based on averages calculated form a large population.
        </li>
        li id="myli"
            Progression:
            The process of spreading or becoming more severe.
        </li>
        li id="myli"
            Prophylactic:
            Guarding against or preventing disease.
        </li>
        li id="myli"
            Prophylactic Cranial Irradiation (PCI):
            Radiation to the brain, done at a lower dose than those used for treatment, used after successful treatment of small cell lung cancer to try to prevent the disease from spreading to the brain.
        </li>
        li id="myli"
            Protocol:
            A detailed plan of treatment or procedure.
        </li>
        li id="myli"
            Psychosocial Support:
            Support designed to meet emotional, psychological, and social needs.
        </li>
        li id="myli"
            Pulmonary:
            Relating to the lungs.
        </li>
        li id="myli"
            Pulmonary Embolism:
            A blood clot that travels to the lungs, causing a full or partial blockage of one or both pulmonary arteries.
        </li>
        li id="myli"
            Pulmonologist:
            A doctor specializing in the diagnosis and treatment of lung diseases.    </li>
        <h1>Q</h1>
        <br>
        <br>
        li id="myli"
            Quality of Life:
            Relates to the general ability to perform daily living tasks and to enjoy life.
        </li>
        <h1>R</h1>
        <br>
        <br>
        li id="myli"
            Radiation:
            Energy carried by waves or a stream of particles.
        </li>
        li id="myli"
            Radiation Field:
            The part of the body that receives radiation.
        </li>
        li id="myli"
            Radiation Oncologist:
            A physician who specializes in radiation therapy for treatment of cancer.
        </li>
        li id="myli"
            Radiation Surgery:
            A type of therapy that delivers a single high dose of radiation directly to the tumor, sparing the healthy tissue from the effects of the radiation; also known as radiosurgery, stereotactic body radiation therapy, and stereotactic external beam irradiation.
        </li>
        li id="myli"
            Radiation Therapy:
            A type of treatment that uses high-energy radiation to shrink tumors and kill cancer cells.
        </li>
        li id="myli"
            Radiologist:
            A physician with training in reading diagnostic radiological tests and performing radiological treatments.
        </li>
        li id="myli"
            Radiosensitization:
            The use of drugs that make tumor cells more sensitive to the effects of radiation therapy
        </li>
        li id="myli"
            Randomized Clinical Trial:
            Trial design in which participants are assigned by chance to a group for study.
        </li>
        li id="myli"
            Radon:
            An invisible, tasteless, radioactive gas that occurs naturally in soil and rocks, exposure to which is a risk factor for lung cancer.
        </li>
        li id="myli"
            Recurrence:
            When cancer returns.
        </li>
        li id="myli"
            Recurrent Cancer:
            Cancer that has come back after treatment; may occur in the original site or it may return elsewhere in the body.
        </li>
        li id="myli"
            Red Blood Cell (RBC):
            A type of blood cell that carries oxygen to the cells of the body and removes carbon dioxide.
        </li>
        li id="myli"
            Red Blood Cell Count:
            The measurement of the number of red blood cells present in the blood.
        </li>
        li id="myli"
            Refractory Cancer:
            Cancer that does not respond or stops responding to treatment.
        </li>
        li id="myli"
            Regimen:
            The plan that outlines the dosage, schedule and duration of treatment.
        </li>
        li id="myli"
            Regional Involvement:
            The spread of cancer from its original site to nearby surrounding areas.
        </li>
        li id="myli"
            Remission:
            The complete disappearance of cancer cells and symptoms; does not always mean the patient has been cured.
        </li>
        li id="myli"
            Resectable (Operable):
            Able to be surgically removed.
        </li>
        li id="myli"
            Resection:
            Surgical removal.
        </li>
        li id="myli"
            Respiration:
            The exchange of oxygen and carbon dioxide between the atmosphere and the cells of the body.
        </li>
        li id="myli"
            Risk Factor:
            Any factor that may increase a person’s chances for developing a disease.
        </li>
        li id="myli"
            Risk Reduction:
            Techniques used to reduce the chances of developing a disease.
        </li>

        <h1>S</h1>
        <br>
        <br>
        li id="myli"
            Screening:
            Checking for disease before there are symptoms.
        </li>
        li id="myli"
            Second-Line Therapy:
            Treatment used after initial treatment.
        </li>
        li id="myli"
            Secondary Tumor (Secondary Cancer):
            A tumor that develops as a result of metastases or spread beyond the original cancer.
        </li>
        li id="myli"
            Segmental Resection:
            The surgical removal of a segment or wedge of lung tissue.
        </li>
        li id="myli"
            Side Effect:
            A secondary effect caused by treatment.
        </li>
        li id="myli"
            Small Cell Lung Cancer:
            One of the two main categories of lung cancer; faster growing than non-small cell lung cancer.
        </li>
        li id="myli"
            Small Molecule Drugs:
            A kind of cancer treatment that can get inside the cancer cell to stop them from functioning normally, which usually causes it to die; one type of small-molecule drugs are tyrosine kinase inhibitors (TKIs).
        </li>
        li id="myli"
            Solid Tumor:
            Cancer of the body tissues other than blood, bone marrow or the lymphatic system; lung cancer is a solid tumor.
        </li>
        li id="myli"
            Sputum:
            Mucus from the bronchial tubes; phlegm.
        </li>
        li id="myli"
            Sputum Cytology:
            The examination of cells in sputum; usually used to look of the presence of cancer cells.
        </li>
        li id="myli"
            Squamous Cell Carcinoma:
            A subtype of non small cell lung cancer; begins in the thin, flat cells that line the passages of the respiratory tract.
        </li>
        li id="myli"
            Stable Disease:
            A cancer that is not growing or shrinking.
        </li>
        li id="myli"
            Stage:
            A determination of the extent of cancer (See Stages of Lung Cancer).
        </li>
        li id="myli"
            Standard Treatment:
            Treatment that has been proven effective and is commonly used.
        </li>
        li id="myli"
            Stereotactic Radiosurgery (STRS):
            A type of external radiation therapy that uses special equipment to position the patient and precisely give a single large dose of radiation to a tumor; used to treat brain metastasis and, increasingly, to remove lung tumors that cannot be treated by regular surgery.
        </li>
        li id="myli"
            Supplementation:
            Adding nutrients, such as vitamins, to the diet.
        </li>
        li id="myli"
            Surgeon:
            A physician who treats disease and injury by performing an operation.
        </li>
        li id="myli"
            Surgery:
            An operation.
        </li>
        li id="myli"
            Surgical Biopsy:
            The surgical removal of tissue to be examined under a microscope to determine if cancer is present.
        </li>
        li id="myli"
            Symptom:
            Something that indicates the presence of an abnormality in relation to the body and/or its functions.
        </li>
        li id="myli"
            Systemic Disease:
            A disease that affects the entire body rather than only one organ.
        </li>
        li id="myli"
            Systemic Symptoms:
            Symptoms affecting the whole body; fever, night sweats, weight loss.
        </li>
        li id="myli"
            Systemic Treatment:
            Treatment that reaches cells all over the body by traveling through the bloodstream; most chemotherapies for lung cancer are systemic treatments.
        </li>

        <h1>T</h1>
        <br>
        <br>
        li id="myli"
            Taste Alteration:
            Temporary change in taste that may be a side effect of chemotherapy, cancer, or radiation.
        </li>
        li id="myli"
            Therapy:
            Treatment.
        </li>
        li id="myli"
            Thoracentesis:
            The removal of fluid, by needle, from the space between the lungs and chest wall (pleural space).
        </li>
        li id="myli"
            Thoracic Surgeon:
            A physician who specializes in performing chest surgery.
        </li>
        li id="myli"
            Thoracoscope:
            An instrument fitted with a lighting system and telescopic attachment for examining the chest cavity.
        </li>
        li id="myli"
            Thoracotomy:
            A surgical procedure in which an incision is made through the chest wall to examine structures in the chest for the presence of cancer or other disease and to remove tumors or sections of the lung.
        </li>
        li id="myli"
            Thorax:
            The upper part of the trunk between the neck and the abdomen.
        </li>
        li id="myli"
            Tissue:
            A group of similar cells that works together to perform a specific function.
        </li>
        li id="myli"
            Tolerance:
            The ability to endure the effects of a drug without exhibiting the usually unfavorable effects.
        </li>
        li id="myli"
            Toxicity:
            The degree to which something is harmful or poisonous.
        </li>
        li id="myli"
            Trachea:
            Windpipe; allows for the passage of air from the larynx to the bronchial tubes.
        </li>
        li id="myli"
            Transfusion:
            The infusion of whole blood or blood components into the bloodstream.
        </li>
        li id="myli"
            Tumor:
            Mass of tissue formed by a new growth of cells; may be benign or cancerous.
        </li>
        li id="myli"
            Tumor Board:
            A group of specialists who meet regularly to discuss management of individuals who have cancer.
        </li>
        li id="myli"
            Tumor Marker:
            Proteins and other substances found in the blood that signify the presence of cancer somewhere in the body.
        </li>
        <h1>U</h1>
        <br>
        <br>
        li id="myli"
            Ultrasound:
            A medical test that uses sound waves to create an image of the inside of the body.
        </li>
        li id="myli"
            Undifferentiated cells:
            Cells that lack the structure and function of normal cells and grow uncontrollably; undifferentiated cells are faster growing than those that are differentiated or poorly differentiated.
        </li>
        li id="myli"
            Unresectable (Inoperable):
            Unable to be surgically removed.
        </li>
        <h1>V</h1>
        <br>
        <br>
        li id="myli"
            Vaccine:
            A substance or group of substances meant to cause the immune system to respond to a tumor or to microorganisms, such as bacteria or viruses. A vaccine can help the body recognize and destroy cancer cells or microorganisms.
        </li>
        li id="myli"
            Vascular endothelial growth factor (VEGF):
            A protein made by cells that stimulates blood vessel growth and makes cancer cells grow more rapidly.
        </li>
        li id="myli"
            Vein:
            A blood vessel that carries blood to the heart.
        </li>
        li id="myli"
            Video Assisted Thorascopic (Thoracic) Surgery (VATS):
            A minimally invasive type of surgery that uses smaller incisions and typically requires less recovery time than typical lung cancer surgery (See Thoracotomy).
        </li>

        <h1>W</h1>
        <br>
        <br>
        li id="myli"
            Wedge Resection:
            The surgical removal of the tumor and a small amount of lung tissue (a wedge) surrounding the tumor.
        </li>
        li id="myli"
            White Blood Cell:
            The cells that are part of the immune system and that fight infection, produce antibodies, and attack and destroy viruses, bacteria, and cancer cells.
        </li>
        li id="myli"
            White Blood Cell Count:
            The total number of white blood cells present in the blood.
        </li>

        <h1>X</h1>
        <br>
        <br>
        li id="myli"
            X-Ray:
            Uses small amounts of radiation to take a two dimensional picture of the inside of the body.
        </li>
    </ul>

    <p>Some definitions or portions thereof are derived from the National Cancer Institute’s Dictionary of Cancer Terms.</p>


</div>
<script>
//    var xhr= new XMLHttpRequest();
//    xhr.open('GET', '../html/glossary.html', true);
//    xhr.onreadystatechange= function() {
//        if (this.readyState!==4) return;
//        if (this.status!==200) return; // or whatever error handling you want
//        document.getElementById('x').innerHTML= this.responseText;
//    };
//    xhr.send();


        function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        console.log("input si + "+ filter);
        ul=document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
    }
        else {
        li[i].style.display = "none";
    }
    }
    }
</script>






<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
</div>
</body>
<div class="clear"></div>


</html>