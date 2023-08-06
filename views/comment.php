<div class="contentPage">
    <div class="container-fluid m-auto mt-5">
        <div class="row mb-5">
            <div class="col text-start"><a class="btn cursor status-size btn-light text-dark rounded rounded-pill
                             border border-dark border-2 border">Statut : <span class="<?php echo $idea->color() ?>"><?php echo $idea->statusDisplay() ?></span></a></div>
            <div class="col">
                <div class="display-4 col text-center">
                    <a class="text-decoration-none text-danger fw-bold" href="index.php?action=comment&&id_idea=<?php echo $idea->getIdIdea() ?>"><?php echo $idea->getHtmlTitle() ?></a>
                </div>
            </div>
            <div class="col text-end">
                <form method="post" action="index.php?action=comment&&id_idea=<?php echo $idea->getIdIdea() ?>">
                    <button type="submit" name="button_vote" value="button_vote" class="fs-1 bg-transparent btn btn-lg shadow-none text-dark text-decoration-none">
                        <img src="views/images/thumb.png" width="60" alt="vote" class="img-fluid thumb"> <?php echo $idea->getNumberOfVotes() ?>
                    </button>
                </form>
            </div>
        </div>

        <?php if ($notification != '') { ?>
            <div class="row "><p class="alert <?php echo $this->colorNotification($notification) ?> display-6 text-center"> <?php echo $notification ?></p></div>
        <?php } ?>

        <div class="row mt-5">
            <div class="col-lg-3  border border-dark border-3 rounded-start bg-secondary">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 m-auto">
                            <img class="img-fluid mx-auto d-block text-center" width="180" alt="photo de profil" src="<?php echo $idea->getAuthor()->getImage() ?>">
                        </div>
                        <div class="col-md-8 m-auto">
                            <p class="text-white fs-1 text-center">Auteur : <?php echo $idea->getAuthor()->getHtmlUsername() ?></p>
                            <p class="text-white fs-1 text-center">Rôle : <span class="
                                    <?php echo $idea->getAuthor()->getColorStatus() ?>
                                     fw-bold"><?php echo $idea->getAuthor()->getStatus() ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col border border-dark rounded-end border-3 mx-2 mt-lg-0 mt-2 bg-secondary">
                <div class="py-5 container">
                    <p class="text-white text-center fs-2"> <?php echo $idea->getHtmlText() ?> </p>
                </div>
                <div class="row col text-start">
                    <div class="col text-start"><a class="btn cursor status-size btn-light text-dark rounded rounded-pill
                             border border-dark border-2 border"><span><?php echo $idea->dateSubmittedDisplay() ?></span></a></div>
                </div>
            </div>


        </div>
    </div>
    <?php foreach ($comments as $i => $comment) { ?>
        <div class="row mt-5">
            <div class="col-lg-3 border border-dark border-3 rounded-start bg-blue">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 m-auto">
                            <img class="img-fluid mx-auto d-block text-center" width="180" alt="photo de profil" src="<?php echo $comment->getAuthor()->getImage() ?>">
                        </div>
                        <div class="col-md-8 m-auto">
                            <p class="text-white fs-1 text-center">Auteur : <?php echo $comment->getAuthor()->getHtmlUsername() ?></p>
                            <p class="text-white fs-1 text-center">Rôle : <span class="
                                    <?php echo $comment->getAuthor()->getColorStatus() ?>
                                     fw-bold"><?php echo $comment->getAuthor()->getStatus() ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col border border-dark rounded-end border-3 mx-2 mt-lg-0 mt-2 bg-blue">

                <div class="py-5">
                    <p class="text-white text-center fs-2"> <?php echo $comment->getHtmlText() ?> </p>
                </div>
                <?php if ($comment->isAfterClosedDate($idea->getTimestampClosed())) { ?>
                    <div>
                        <p class="text-warning fw-bold fst-italic fs-4 text-center"> Ce commentaire a été posté après la date de fermeture du sujet </p>
                    </div>
                <?php } ?>

                    <div class="row">
                        <div class="col text-start">
                            <div class="col text-start"><a class="btn cursor status-size btn-light text-dark rounded rounded-pill
                             border border-dark border-2 border"><span><?php echo $comment->getTimestampDisplay() ?></span></a></div>
                        </div>
                        <?php if ($comment->getAuthor()->getHtmlUsername() == USERNAME && !$comment->isDeleted()) { ?>
                        <div class="col text-end">
                            <form method="post" action="index.php?action=comment&&id_idea=<?php echo $idea->getIdIdea() ?>">
                                <button type="submit" name="delete_comment" value="<?php echo $comment->getIdComment() ?>"
                                        class="btn btn-lg btn-light fs-2 text-dark btn-outline-danger border border-dark border-2">Supprimer
                                </button>
                            </form>
                        </div>
                        <?php } ?>
                    </div>

            </div>

        </div>
    <?php } ?>

    <div class="row border border-dark border-3 mt-5 m-auto" style="background-color: rgba(0,0,0,0.7)">
        <?php if ($notificationComment != '') { ?>
            <p class="alert <?php echo $this->colorNotification($notificationComment) ?> fs-1 text-center"><?php echo $notificationComment ?></p>
        <?php } ?>
        <form method="post" action="index.php?action=comment&&id_idea=<?php echo $idea->getIdIdea() ?>">
            <div class="mb-3">
                <label class="form-label fs-1 text-white">Réponse</label>
                <textarea name="text" class="form-control form-control-lg fs-3" placeholder="Votre idée principale" rows="3"></textarea>
            </div>
            <div class="text-center pb-2">
                <button type="submit" name="form_answer" value="form_answer" class="btn btn-warning btn-lg fs-1 w-50">Répondre</button>
            </div>
        </form>
    </div>
</div>