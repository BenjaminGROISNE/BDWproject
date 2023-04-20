
<div class="panneau">

  <div>  <!-- Premier bloc permettant l'affichage de la liste des tables -->

	<h2>Liste des tables</h2>


	<?php if( $message_liste != "" ) { ?>

		<p class="notification"><?= $message_liste  ?></p>

	<?php }else{?>

	<table class="table_resultat">
		<thead>
			<tr><th>Nom de table</th></tr>
		</thead>
		<tbody>

		<?php foreach($tables as $t) { ?>
		<tr><td><?= BDD . '.' . $t['table_name'] ?></td></tr>
		<?php } ?>

	</tbody>
	</table>

	<?php }?>

  </div>

  <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une table -->

	<h2>Détails d'une table</h2>


	<form class="bloc_commandes" method="post" action="#">	

		<label for="typeVueTable">Voir</label>		
		<select name="typeVue" id="typeVue">
				<option value="schema">Schéma</option>
				<option value="data">Instances</option>
		</select>
		
		<label for="choixTable">pour la table</label>
		<select name="nomTable" id="nomTable">

			<?php foreach($tables as $t) { ?>
				<option value="<?= $t['table_name'] ?>"><?= $t['table_name'] ?></option>
			<?php } ?>
		</select>

		<input type="submit" name="boutonAfficher" value="Afficher"/>
	</form>

	<div>
		<?php if( isset($resultats) ){
			
			if( is_array($resultats) ){ 
		?>
			<table class="table_resultat">
				<thead>
					<tr>
					<?php
						//var_dump($resultats);
						foreach($resultats['schema'] as $att) {  // pour parcourir les attributs
				
							echo '<th>';
								echo $att['nom'];
							echo '</th>';
				
						}
					?>	
					</tr>	
				</thead>
				<tbody>

				<?php
					foreach($resultats['instances'] as $row) {  // pour parcourir les n-uplets
				
					echo '<tr>';
					foreach($row as $valeur) { // pour parcourir chaque valeur de n-uplets
				
						echo '<td>'. $valeur . '</td>';
					}
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		
		<?php }else{ ?>

			<p class="notification"><?= $message_details . 'TOOT' ?></p>	

		<?php }

	} ?>
	</div>


</div>


</div>