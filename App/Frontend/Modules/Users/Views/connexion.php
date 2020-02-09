<div class="pageConnexion">
	<!-- Zone formulaire  -->
	<div class="zone-formulaire">
		<?php if ($user->hasFlash()) echo '<p class="ligneErreur">',$user->getFlash(), '</p>'; ?>
	  <div class="formulaire">
	    <p id="titreFormulaire">Connexion</p>
		  <form action ="" method="post" class="formulaireMessage">
		 	  <?= $form ?>
        <div id="btnValid">
		    	<input type="submit" value="Connexion" class="btnValid" />
		    </div>
	    </form>
	  </div>
	</div>
</div>

