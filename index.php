<?php
include 'konek/koneksi.php';
$messageStatus = ''; // Variabel untuk menyimpan status pengiriman pesan

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Ambil data dari form
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $message = mysqli_real_escape_string($koneksi, $_POST['message']);
    $created_at = date('Y-m-d H:i:s'); // Timestamp saat data dikirim

    // Query untuk memasukkan data ke dalam tabel 'find_me'
    $queryInsertMessage = "INSERT INTO find_me (name, email, message, created_at, id_user) 
                           VALUES ('$name', '$email', '$message', '$created_at', 1)";

    if (mysqli_query($koneksi, $queryInsertMessage)) {
        $messageStatus = 'Pesan Anda telah terkirim!';
    } else {
        $messageStatus = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
    }

    // Redirect untuk mencegah kotak dialog muncul kembali saat refresh
    header("Location: index.php?status=" . urlencode($messageStatus));
    exit;
    }

    // Tangkap status dari URL (jika ada)
    if (isset($_GET['status'])) {
    $messageStatus = urldecode($_GET['status']);
    }

// Mengambil data pengguna
$queryUser = "SELECT * FROM users WHERE id_user = 1"; // Misal kita ambil user dengan ID 1
$resultUser = mysqli_query($koneksi, $queryUser);
$userData = mysqli_fetch_assoc($resultUser);

// Mengambil data pendidikan
$queryEducation = "SELECT * FROM education WHERE id_user = 1";
$resultEducation = mysqli_query($koneksi, $queryEducation);

// Mengambil data pengalaman
$queryExperience = "SELECT * FROM experience WHERE id_user = 1";
$resultExperience = mysqli_query($koneksi, $queryExperience);

// Mengambil data keterampilan
$querySkills = "SELECT * FROM skills WHERE id_user = 1";
$resultSkills = mysqli_query($koneksi, $querySkills);

// Mengambil data portfolio
$queryPortfolio = "SELECT * FROM portfolio WHERE id_user = 1";
$resultPortfolio = mysqli_query($koneksi, $queryPortfolio);

// Query untuk mengambil data dari tabel 'find_me'
$queryFindMe = "SELECT * FROM find_me WHERE id_user = 1 ORDER BY id_find_me ASC";
$queryMessages = "SELECT name, email, message, created_at FROM find_me WHERE id_user = 1 AND message IS NOT NULL ORDER BY created_at DESC";
$resultFindMe = mysqli_query($koneksi, $queryFindMe);

$koneksi->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Art - Biodata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo-sticky">3D</div>
        <!-- Navbar -->
        <nav>
            <ul>
                <li><a href="#biodata">Biodata</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#experience">Experience</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#findme">Find Me</a></li>
            </ul>
        </nav>
    </header>

    <!-- Biodata Section -->
    <section id="biodata">
        <div class="intro">
            <h1>I'm a <span class="hollow-text">3D Art</span></h1>
            <p>Hello! I’m <?php echo $userData['profession']; ?>, specializing in animation and visual products, 3D icons, and decorative elements for landing pages. With over 7 years of experience in the creative industry, I have worked on more than 100 projects covering a wide range of visual and aesthetic needs. My expertise includes modeling, animation, and arranging visual elements to bring ideas to life in a captivating and effective way.</p>
        </div>
        <div class="profile-picture">
            <img class="pulse" src="<?php echo $userData['profile_picture']; ?>" alt="Profile Picture">
        </div>
    </section>

    <!-- Education Section -->
    <section id="education">
        <h2>Education</h2>
        <div class="card-container-edu">
            <?php while ($education = mysqli_fetch_assoc($resultEducation)) { ?>
                <div class="cardedu">
                    <div class="card-content">
                        <div class="text-content">
                            <h4><?php echo $education['institution_name']; ?></h4>
                            <h5><?php echo nl2br($education['major']); ?></h5>
                            <p><?php echo $education['start_year']; ?> - <?php echo $education['end_year']; ?></p>
                        </div>
                        <div class="image-content">
                            <img src="<?php echo $education['image']; ?>" alt="School Logo">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience">
        <h2>Experience</h2>
        <div class="card-container">
            <?php while ($experience = mysqli_fetch_assoc($resultExperience)) { ?>
                <div class="card center-card">
                    <img src="<?php echo $experience['image']; ?>" alt="Experience Image">
                    <h3><?php echo $experience['position']; ?></h3><br>
                    <h4><?php echo $experience['year']; ?></h4><br>
                    <p><?php echo $experience['description']; ?></p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills">
        <h2>Skills</h2>
        <div class="card-container-skills">
            <?php while ($skill = mysqli_fetch_assoc($resultSkills)) { ?>
                <div class="card2">
                    <i class="<?php echo $skill['icon']; ?>"></i>
                    <h3 class="card-subtitle"><?php echo $skill['skill_name']; ?></h3>
                    <p class="card-text"><?php echo $skill['skill_description']; ?></p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio">
        <h2>Portfolio</h2>
        <div class="portfolio-container">
            <?php while ($portfolio = mysqli_fetch_assoc($resultPortfolio)) { ?>
                <div class="portfolio-card">
                    <img src="<?php echo $portfolio['image']; ?>" alt="Portfolio Image" class="card-image">
                    <h3 class="card-subtitle2"><?php echo $portfolio['title']; ?></h3>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Find Me Section -->
    <section id="findme">
        <div class="content-findme">
            <h1>Find Me On</h1>
            <h2>Your vision matters to us.<br>Let’s connect and make it<br>happen!</h2>
            <div class="social-icons">
        <?php while ($findMe = mysqli_fetch_assoc($resultFindMe)) { ?>
        <?php if (!empty($findMe['url']) && !empty($findMe['icon'])) { ?>
            <a href="<?php echo $findMe['url']; ?>" class="social-btn" target="_blank">
                <i class="<?php echo $findMe['icon']; ?>"></i>
            </a>
        <?php } ?>
            <?php } ?>
</div>

        </div>
        <div class="right-column">
    <form class="contact-form" method="POST" action="">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="message" placeholder="Message" required></textarea>
        <button type="submit" name="submit">Send Message</button>
    </form>
</div>
    </section>
    <footer class="footer">
        <p>Copyright &#169; 2024 Sinta Wulandari 3D Art | All rights reserved.</p>
    </footer> 
    <?php if ($messageStatus != ''): ?>
        <script type="text/javascript">
            alert("<?php echo $messageStatus; ?>");
        </script>
    <?php endif; ?>
</body>
</html>