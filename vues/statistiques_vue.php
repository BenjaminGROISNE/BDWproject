
<div class="panneau">

  <div>  <!-- Bloc permettant d'afficher les statistiques -->

	<h2>Statistiques de la base</h2>


	<?php if( $message != "" ) { ?>

		<p class="notification"><?= $message ?></p>

	<?php }else{?>

	<table class="table_resultat">
		<thead>
			<tr><th>Propriété</th><th>Valeur</th></tr>
		</thead>
		<tbody>

		<tr><td>Nombre de tables</td><td><?= $stats['nbTables'] ?></td></tr>
        <tr><td>Nombre de tuples</td><td><?= $stats['nbTuples'] ?></td></tr>

	</tbody>
	</table>

	<?php }?>

  </div>

</div>	