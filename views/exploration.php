<div class="container-fluid contentPage">

    <div class="websiteFont row mx-3 mb-5">

        <div class="backgroundGray col-lg-2 border border-dark border-2 m-auto">

            <form method="post" action="index.php?action=exploration" class="pt-2 text-center">
                <p class="bg-light bg-gradient rounded fs-1 ">Filtre</p>

                <div class=" btn-group-vertical btn-group-lg pt-3 filter ">
                    <button class="btn btn-outline-warning border-white text-white fs-2" name="status_form" value="all">Aucun</button>
                    <button class="btn btn-outline-success border-white text-white fs-2" name="status_form" value="Submitted">Soumis</button>
                    <button class="btn btn-outline-primary border-white text-white fs-2" name="status_form" value="Accepted">Validé</button>
                    <button class="btn btn-outline-danger border-white text-white fs-2" name="status_form" value="Refused">Refusé</button>
                    <button class="btn btn-outline-secondary border-white text-white fs-2 mb-4" name="status_form" value="Closed">Fermé</button>
                </div>


                <p class="bg-light bg-gradient rounded fs-1 mb-5 ">📈Tri</p>
                <div>
                    <select class="form-select fs-3 text-center form-select-lg mb-3" name="sort" aria-label=".form-select-lg example">
                        <option value="popular" <?php echo $popularSelected ?> >Popularité croissante</option>
                        <option value="unpopular" <?php echo $unpopularSelected ?>>Popularité décroissante</option>
                        <option value="recentDate" <?php echo $recentDate ?>>Date récente</option>
                        <option value="oldDate" <?php echo $oldDate ?>>Date ancienne</option>
                    </select>
                </div>
                <div class=" btn-group-vertical btn-group-lg pt-3 filter ">
                    <div class=" btn-group-vertical btn-group-lg pt-3 filter ">
                        <button class="btn btn-outline-success border-white text-white fs-2" name="limit" value="3">3 idée</button>
                        <button class="btn btn-outline-success border-white text-white fs-2" name="limit" value="10">10 idée</button>
                        <button class="btn btn-outline-success border-white text-white fs-2 mb-4" name="limit" value="all">Tous</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-10 mt-5 mb-5">
            <div class="row border border-dark border-3 text-center text-white m-auto bg-blue ">
                <h1 class="display-2 text-white text-decoration-underline pb-5" id="titleIdea">Exploration des idées</h1>
                <p class="fs-1"> Bienvenue <?php echo USERNAME ?> sur la page exploration ! <br>
                Ici vous pouvez poster vos idées et consulter celles des autres membres de Metakritik <br>
                Si une idée vous plaît, vous pouvez voter pour celle-ci afin de la mettre en avant 😄  </p>
            </div>

            <div class="row border border-dark border-3 mt-5 backgroundGray m-auto">
                <?php if($notification != ''){?>
                <p class="alert <?php echo $this->colorNotification($notification) ?> fs-1 text-center"><?php echo $notification ?></p>
                <?php } ?>

                <form method="post" action="index.php?action=exploration">
                <div class="mb-3">
                    <label class="form-label fs-1 text-white">Titre</label>
                    <input type=text name="title" class="form-control form-control-lg fs-2" placeholder="Titre du sujet (60 caractères maximum)">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-1 text-white">Idée</label>
                    <textarea name="text" class="form-control form-control-lg fs-3" placeholder="Votre idée principale" rows="3"></textarea>
                </div>
                <div class="text-center pb-2">
                    <button type="submit" name="form_comment" value="form_comment" class="btn btn-warning btn-lg fs-1 w-50">Poster</button>
                </div>
                </form>
            </div>
        </div>
        <?php if ($notificationVote != '') { ?>
            <div class="row "><p class="alert <? echo $this->colorNotification($notification) ?> fw-bold display-6 text-center"> <?php echo $notificationVote ?></p></div>
        <?php } ?>
        <div class="row bg-secondary border-dark mt-5 border border-5"><p class="text-center text-white fs-1">Nombre de sujets : <?php echo count($tabIdea) ?></p></div>
        <?php foreach ($tabIdea as $i => $idea){ ?>
            <div class="container-fluid m-auto mt-5">
                <div class="row">
                    <div class="col-lg-3  border border-dark border-3 rounded-start bg-blue">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 m-auto">
                                    <img class="img-fluid mx-auto d-block text-center" width="180" alt="photo de profil" src="<?php echo $idea->getAuthor()->getImage() ?>">
                                </div>
                                <div class="col-md-8 m-auto">
                                <!-- pas d'appel à la db depuis la vue, la vue ne peut s'appuyer que sur des variables qu'elle recoit, elle ne doit pas déclencher de nouvelles requetes, c'est le controlleur qui est responsable d'appeler la db -->
                                    <p class="text-white fs-1 text-center">Auteur : <?php echo $idea->getAuthor()->getHtmlUsername() ?></p>
                                    <p class="text-white fs-1 text-center">Rôle : <span class="
                                    <?php echo $idea->getAuthor()->getColorStatus() ?>
                                     fw-bold"><?php echo $idea->getAuthor()->getStatus() ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col border border-dark rounded-end border-3 mx-2 mt-lg-0 mt-2 bg-blue">
                        <div class="row mb-0 mb-md-1">
                            <div class="col text-start"><a class="btn cursor status-size btn-light text-dark rounded rounded-pill
                             border border-dark border-2 border">Statut : <span class="<?php echo $idea->color() ?>"><?php echo $idea->statusDisplay() ?></span></a></div>
                            <div class="col text-end">
                                <form method="post" action="index.php?action=exploration">
                                    <button type="submit" name="button_vote" value="<?php echo $idea->getIdIdea() ?>" class="fs-2 bg-transparent btn btn-lg shadow-none text-white text-decoration-none">
                                        <img src="views/images/thumb.png" width="60" alt="vote" class="img-fluid thumb"> <?php echo $idea->getNumberOfVotes(); ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row mb-5"><div class="display-4 col text-center  fw-bold titleIdeas"><a href="index.php?action=comment&&id_idea=<?php echo $idea->getIdIdea() ?>"><?php echo $idea->getHtmlTitle() ?></a></div></div>
                        <div class="row mt-2">
                            <p class="text-white text-center fs-2"> <?php echo $idea->getTextPreview() ?> </p>
                        </div>
                        <div class="row">
                            <div class="col text-start">
                                <div class="col text-start"><a class="btn cursor status-size btn-light text-dark rounded rounded-pill
                             border border-dark border-2 border"><span><?php echo $idea->dateSubmittedDisplay() ?></span></a></div>
                            </div>
                            <div class="col text-end">                                
                                <a href="index.php?action=comment&&id_idea=<?php echo $idea->getIdIdea()?>" class="btn btn-lg btn-light fs-2 text-dark btn-outline-warning border border-dark border-2 rounded rounded-pill">Commentaires ( <?php echo $idea->getNumberOfComments();  ?> )</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</div>
