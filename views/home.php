<div id='homeBackground'>

    <div class="accueil">
        <h1 class="text-warning display-1 fw-bold">M E T A K R I T I K</h1>
        <div><h2 class="display-4 text-white fw-bolder"><?php echo $notification ?></h2></div>
        <button type="button" class="btn btn-primary fs-1" data-bs-toggle="modal" data-bs-target="#login">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
            Se connecter
        </button>
        <button type="button" class="btn btn-light fs-1" data-bs-toggle="modal" data-bs-target="#register">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
            </svg>
            S'enregistrer
        </button>
    </div>

    <!-- Login modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Se connecter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php?action=accueil">
                        <div class="mb-3">
                            <label class="form-label">Adresse email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $emailLogin ?>">
                            <div class="form-text">Maximum 60 caractères pour votre adresse email</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <input type="submit" name="loginForm" class="btn btn-primary" value="Se connecter">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Revenir à l'accueil</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register modal -->

    <div class="modal fade" id="register" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">S'inscrire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php?action=accueil">
                        <div class="mb-3">
                            <label class="form-label">Adresse email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email ?>">
                            <div class="form-text">Maximum 60 caractères pour votre adresse email</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pseudonyme</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                            <div class="form-text">Maximum 20 caractères pour votre pseudonyme</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <input value="S'enregistrer" type="submit" name="registerForm" class="btn btn-primary">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Revenir à l'accueil</button>
                </div>
            </div>
        </div>
    </div>
</div>
