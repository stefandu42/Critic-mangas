<div class="contentPage">
    <h1 id="titleProfil">Mon profil</h1>


    <br>
    <!-- fields and picture -->
    <div class="row" id="profil">
        <!-- space left -->
        <div class="col-md-1 col-lg-2"></div>
        <!-- fields -->
        <div class="col-sm-6 col-md-6 col-lg-6">
            <p class="field">Pseudo : <?php echo USERNAME?></p>
            <p class="field">Adresse Email : <?php echo EMAIL?></p>
            <p class="field">Mon statut : Admin</p>
        </div>
        <!-- image -->
        <div class="col-sm-6 col-md-2 col-lg-3">
            <img class="img-fluid" src="<?php echo IMAGE ?>" alt="admin picture" width="180" id="picProfil">
        </div>
    </div>

    <br>

    <!-- buttons and table -->
    <form action="index.php?action=admin" method="post">
        <!-- buttons -->
        <div class="buttonsFlex">
            <button type="submit" class="btn btn-primary btn-lg" name="members" value="members"><i class="fa fa-address-card-o"></i> Membres</button>
            <button type="submit" class="btn btn-primary btn-lg" name="ideas" value="ideas"><i class="fa fa-th-list"></i> Idées</button>
        </div>

        <br>

        <!-- table -->
        <?php if($displayTable){?>
            <div id="divTable">
                <table id="table">
                    <!-- head of table -->
                    <tr>
                        <?php if($button=='members'){?>
                            <th>Pseudo</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Suspendu</th>
                            <th>Suspendre</th>
                            <th>Promouvoir</th>
                        <?php } else if($button=='ideas'){?>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Statut</th>
                            <th>Auteur</th>
                            <th>Date mise en ligne</th>
                            <th>Date de cloture</th>
                            <th>Date statut modifié</th>
                            <th>Valider</th>
                            <th>Refuser</th>
                            <th>Fermer</th>
                        <?php }?>


                    </tr>
                    <!-- content of table members -->
                    <?php if($button=='members'){
                        foreach ($tabMembers as $number => $member) {?>
                            <tr>
                                <td><?php echo $member->getHtmlUsername()?></td>

                                <td><?php echo $member->getHtmlEmail()?></td>

                                <!-- if member displayed in green color, and admin red color -->
                                <td>
                                    <?php if($member->isMember()){ ?>
                                        <span class="green fw-bold">Membre</span>
                                    <?php }else{ ?>
                                        <span class="red fw-bold">Admin</span>
                                    <?php }?>
                                </td>

                                <td>
                                    <?php if($member->isDisabled()){ ?>
                                        <span class="red fw-bold">Oui</span>
                                    <?php }else{ ?>
                                        <span class="green fw-bold">Non</span>
                                    <?php }?>
                                </td>

                                <td>
                                    <?php if(!$member->isDisabled() && $member->isMember()){?>
                                        <button type="submit" class="btn btn-primary btn-lg" name="disable" value="<?php echo $member->getHtmlEmail()?>"><i class="fa fa-remove"></i> Suspendre</button>
                                    <?php }else{?>
                                        <button type="submit" class="btn btn-secondary btn-lg disabled" name="disable" value="<?php echo $member->getHtmlEmail()?>"><i class="fa fa-remove"></i> Suspendre</button>
                                    <?php }?>
                                </td>

                                <td>
                                    <?php if(!$member->isDisabled() && $member->isMember()){?>
                                        <button type="submit" class="btn btn-primary btn-lg" name="update" value="<?php echo $member->getHtmlEmail()?>"><i class="fa fa-level-up"></i> Promouvoir</button>
                                    <?php }else{?>
                                        <button type="submit" class="btn btn-secondary btn-lg disabled" name="update" value="<?php echo $member->getHtmlEmail()?>"><i class="fa fa-level-up"></i> Promouvoir</button>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php }
                    }?>

                    <!-- content of table ideas -->
                    <?php if($button=='ideas'){
                        foreach ($tabIdeas as $number => $idea) {?>
                            <tr>
                                <td><?php echo $idea->getHtmlTitle()?></td>
                                <td class="w-25"><?php echo $idea->getHtmlText()?></td>
                                <td><span class="<?php echo $idea->color()?>"><?php echo $idea->statusDisplay()?></span></td>
                                <!-- get the author of the idea with the idea of the merber that is in the idea table (FK), in the member table-->
                                <td><?php echo $idea->getAuthor()->getHtmlUsername()?></td>
                                <td><?php echo $idea->dateSubmittedDisplay()?></td>
                                <td><?php echo $idea->dateClosedDisplay()?></td>
                                <td><?php echo $idea->getMaxDateBetweenRefusedAndAccepted()?></td>
                                <td>
                                    <?php if(!$idea->isClosed() && !$idea->isAccepted()){?>
                                        <button type="submit" class="btn btn-primary btn-sm" name="accept" value="<?php echo $idea->getIdIdea()?>"><i class="fa fa-check"></i> Valider</button>
                                    <?php }else{?>
                                        <button type="submit" class="btn btn-secondary btn-sm disabled" name="accept" value="<?php echo $idea->getIdIdea()?>"><i class="fa fa-check"></i> Valider</button>
                                    <?php }?>
                                </td>
                                <td>
                                    <?php if(!$idea->isClosed() && !$idea->isRefused()){?>
                                        <button type="submit" class="btn btn-primary btn-sm" name="refuse" value="<?php echo $idea->getIdIdea()?>"><i class="fa fa-remove"></i> Refuser</button>
                                    <?php }else{?>
                                        <button type="submit" class="btn btn-secondary btn-sm disabled" name="refuse" value="<?php echo $idea->getIdIdea()?>"><i class="fa fa-remove"></i> Refuser</button>
                                    <?php }?>
                                </td>
                                <td>
                                    <?php if(!$idea->isClosed() && !$idea->isSubmitted()){?>
                                        <button type="submit" class="btn btn-primary btn-sm" name="close" value="<?php echo $idea->getIdIdea()?>"><i class="fa fa-lock"></i> Fermer</button>
                                    <?php }else{?>
                                        <button type="submit" class="btn btn-secondary btn-sm disabled" name="close" value="<?php echo $idea->getIdIdea()?>"><i class="fa fa-lock"></i> Fermer</button>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php }
                    }?>

                </table>
            </div>
        <?php }?>
    </form>
</div>