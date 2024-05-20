<nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="index?lang=<?php echo $_SESSION['lang']; ?>">
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
                    <a class="nav-link click-scroll" href="index#section_1?lang=<?php echo $_SESSION['lang']; ?>"><?php echo $lang['home'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="index#section_2?lang=<?php echo $_SESSION['lang']; ?>"><?php echo $lang['donation'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><?php echo $lang['donation_steps'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="invoice?lang=<?php echo $_SESSION['lang']; ?>"><?php echo $lang['list_of_donors'] ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="service?lang=<?php echo $_SESSION['lang']; ?>"><?php echo $lang['benefits'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="index#section_4?lang=<?php echo $_SESSION['lang']; ?>"><?php echo $lang['contact'] ?></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        if ($_SESSION['lang'] == 'th') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                    <mask id="circleFlagsTh0">
                        <circle cx="256" cy="256" r="256" fill="#fff" />
                    </mask>
                    <g mask="url(#circleFlagsTh0)">
                        <path fill="#d80027" d="M0 0h512v89l-79.2 163.7L512 423v89H0v-89l82.7-169.6L0 89z" />
                        <path fill="#eee" d="M0 89h512v78l-42.6 91.2L512 345v78H0v-78l40-92.5L0 167z" />
                        <path fill="#0052b4" d="M0 167h512v178H0z" />
                    </g>
                </svg> ไทย';
                        } elseif ($_SESSION['lang'] == 'en') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                            <mask id="circleFlagsUs0">
                                <circle cx="256" cy="256" r="256" fill="#fff" />
                            </mask>
                            <g mask="url(#circleFlagsUs0)">
                                <path fill="#eee" d="M256 0h256v64l-32 32l32 32v64l-32 32l32 32v64l-32 32l32 32v64l-256 32L0 448v-64l32-32l-32-32v-64z" />
                                <path fill="#d80027" d="M224 64h288v64H224Zm0 128h288v64H256ZM0 320h512v64H0Zm0 128h512v64H0Z" />
                                <path fill="#0052b4" d="M0 0h256v256H0Z" />
                                <path fill="#eee" d="m187 243l57-41h-70l57 41l-22-67zm-81 0l57-41H93l57 41l-22-67zm-81 0l57-41H12l57 41l-22-67zm162-81l57-41h-70l57 41l-22-67zm-81 0l57-41H93l57 41l-22-67zm-81 0l57-41H12l57 41l-22-67Zm162-82l57-41h-70l57 41l-22-67Zm-81 0l57-41H93l57 41l-22-67zm-81 0l57-41H12l57 41l-22-67Z" />
                            </g>
                        </svg> English';
                        } else {
                            echo $_SESSION['lang'];
                        }
                        ?>
                    </a>


                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index?lang=th"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                    <mask id="circleFlagsTh0">
                                        <circle cx="256" cy="256" r="256" fill="#fff" />
                                    </mask>
                                    <g mask="url(#circleFlagsTh0)">
                                        <path fill="#d80027" d="M0 0h512v89l-79.2 163.7L512 423v89H0v-89l82.7-169.6L0 89z" />
                                        <path fill="#eee" d="M0 89h512v78l-42.6 91.2L512 345v78H0v-78l40-92.5L0 167z" />
                                        <path fill="#0052b4" d="M0 167h512v178H0z" />
                                    </g>
                                </svg> <?php echo $lang['lang_th']; ?></a></li>
                        <li><a class="dropdown-item" href="index?lang=en"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                    <mask id="circleFlagsUs0">
                                        <circle cx="256" cy="256" r="256" fill="#fff" />
                                    </mask>
                                    <g mask="url(#circleFlagsUs0)">
                                        <path fill="#eee" d="M256 0h256v64l-32 32l32 32v64l-32 32l32 32v64l-32 32l32 32v64l-256 32L0 448v-64l32-32l-32-32v-64z" />
                                        <path fill="#d80027" d="M224 64h288v64H224Zm0 128h288v64H256ZM0 320h512v64H0Zm0 128h512v64H0Z" />
                                        <path fill="#0052b4" d="M0 0h256v256H0Z" />
                                        <path fill="#eee" d="m187 243l57-41h-70l57 41l-22-67zm-81 0l57-41H93l57 41l-22-67zm-81 0l57-41H12l57 41l-22-67zm162-81l57-41h-70l57 41l-22-67zm-81 0l57-41H93l57 41l-22-67zm-81 0l57-41H12l57 41l-22-67Zm162-82l57-41h-70l57 41l-22-67Zm-81 0l57-41H93l57 41l-22-67zm-81 0l57-41H12l57 41l-22-67Z" />
                                    </g>
                                </svg> <?php echo $lang['lang_en']; ?></a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>