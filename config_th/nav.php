<nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="index?lang=<?= $_GET['lang'] ?>">
            <img src="images/logo.png" class="logo img-fluid">
            <span>
                <h4 style="margin-left: 10px;">E-Donation</h4>
                <h5 style="margin-left: 10px;">NurseCMU</h5>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="index?lang=<?= $_GET['lang'] ?>"><?php echo $lang['home'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="index#section_2?lang=<?= $_GET['lang'] ?>"><?php echo $lang['donation'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><?php echo $lang['donation_steps'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="invoice?lang=<?= $_GET['lang'] ?>"><?php echo $lang['list_of_donors'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="service?lang=<?= $_GET['lang'] ?>"><?php echo $lang['benefits'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="index#section_4?lang=<?= $_GET['lang'] ?>"><?php echo $lang['contact'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="index?lang=th"><?php echo $lang['lang_th'] ?></a>|<a class="nav-link click-scroll" href="index?lang=en"><?php echo $lang['lang_en'] ?></a>
                </li>

            </ul>

        </div>
    </div>
</nav>