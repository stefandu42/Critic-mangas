<div class="contentPage">
    <h1 id="titleProfil">Mon profil</h1>


    <br>
    <!-- fields and picture -->
    <div class="row" id="profil">
        <div class="col-1 col-sm-1 col-md-1 col-lg-2"></div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <p class="field">Pseudo : <?php echo USERNAME ?></p>
            <p class="field">Adresse Email : <?php echo EMAIL?></p>
            <p class="field">Mon statut : <?php echo STATUS ?></p>
        </div>
        <div class="col-sm-6 col-md-2 col-lg-3">
            <img class="img-fluid" src="<?php echo IMAGE ?>" width="180" alt="admin picture" id="picProfil">
        </div>
    </div>

    <br>

    <!-- buttons and table -->
    <form action="index.php?action=profil" method="post">
        <!-- buttons -->
        <div class="buttonsFlex">
            <button type="submit" class="btn btn-primary btn-lg" name="ideas" value="ideas"><i
                        class="fa fa-th-list"></i> Mes idées
            </button>
            <button type="submit" class="btn btn-primary btn-lg" name="comments" value="comments"><i
                        class="fa fa-comments"></i> Mes commentaires
            </button>
            <button type="submit" class="btn btn-primary btn-lg" name="votes" value="votes"><i
                        class="fa fa-thumbs-o-up"></i> Mes votes
            </button>
        </div>

        <br>

        <!-- table -->
        <?php if ($displayTable) { ?>
            <div id="divTable">
                <table id="table">
                    <!-- head of table -->
                    <tr>
                        <?php if ($button == 'comments') { ?>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Auteur</th>
                            <th>Mon commentaire</th>
                            <th>Date mise en ligne</th>
                            <th></th>
                        <?php } else if ($button == 'ideas') { ?>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Statut</th>
                            <th>Votes</th>
                            <th>Date mise en ligne</th>
                        <?php } else if ($button == 'votes') { ?>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Auteur</th>
                        <?php } ?>
                    </tr>

                    <!-- content of table ideas -->
                    <?php if ($button == 'ideas') {
                        foreach ($tabIdeas as $number => $idea) { ?>
                            <tr>
                                <td><?php echo $idea->getHtmlTitle() ?></td>
                                <td class="w-25"><?php echo $idea->getHtmlText() ?></td>
                                <td>
                                    <span class="<?php echo $idea->color() ?>"><?php echo $idea->statusDisplay() ?></span>
                                </td>
                                <td><?php echo $idea->getNumberOfVotes() ?></td>
                                <td><?php echo $idea->dateSubmittedDisplay()?></td>
                            </tr>
                        <?php }
                    } ?>

                    <!-- content of table comments -->
                    <?php if ($button == 'comments') {
                        foreach ($tabComments as $number => $comment) {
                            # do not display the line if the comment is deleted
                            if (!$comment->isDeleted()) { ?>
                                <tr>
                                    <td><?php echo $comment->getIdea()->getHtmlTitle() ?></td>
                                    <td class="w-25"><?php echo $comment->getIdea()->getHtmlText() ?></td>
                                    <td><?php echo $comment->getIdea()->getAuthor()->getHtmlUsername() ?></td><td><?php echo $comment->getHtmlText(); ?></td>
                                    <td><?php echo $comment->getTimestampDisplay() ?></td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm" name="delete"
                                                value="<?php echo $comment->getIdComment() ?>"><i
                                                    class="fa fa-remove"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } ?>

                    <!-- content of table votes -->
                    <?php if ($button == 'votes') {
                        foreach ($tabVotes as $number => $vote) { ?>
                            <tr>
                                <td><?php echo $vote->getIdea()->getHtmlTitle() ?></td>
                                <td class="w-25"><?php echo $vote->getIdea()->getHtmlText()?></td>
                                <td><?php echo $vote->getIdea()->getAuthor()->getHtmlUsername() ?></td>
                            </tr>
                        <?php }
                    } ?>

                </table>
            </div>
        <?php } ?>
    </form>


</div>