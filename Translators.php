<?php
/**
 * SMF translator listing script
 * Written by: Dr. Deejay
 * Written for: SMF localization team
 * Version: 1.0
 *
 * License: BSD
*/

// Include SSI.php
include 'SSI.php';

// Globalize some variables
global $smcFunc;

// Show the header
template_header();

// Some template stuff
echo '
	<div class="cat_bar">
		<h3 class="catbg">
			Translators
		</h3>
	</div>	
	<div class="windowbg2">
		<span class="topslice"><span></span></span>
			<div class="content">
				A list of all SMF translators can be found below.<br /><br />';

// Setup a query to load the languages
$query_languages = $smcFunc['db_query']('', '
		SELECT id_language, name
			FROM language.languages
			ORDER BY name ASC
	',
	array()
);

	// Walk through the results
	while($lang = $smcFunc['db_fetch_row']($query_languages)) {

		// Show the name of the language.
		echo '
				<br /><strong>' . $lang['name'] . '</strong><br />';

		// Now get the translators from the database
		$query_translators = $smcFunc['db_query']('', '
				SELECT t.id_member, t.id_language, t.can_update, m.id_member, m.real_name
					FROM language.permission_languages AS t
					LEFT JOIN {db_prefix}members AS m ON (m.id_member = t.id_member)
					WHERE t.can_update = {int:can_update}
					ORDER BY m.real_name ASC
			',
			array(
				'lang' => $lang['id_language'],
				'can_update' => 1
			)
		);

		// This is what this script is all about: showing translators
		while($translator = $smcFunc['db_fetch_row']($query_translators))
			echo '
					' . $translator['real_name'] . '<br />';
	}

// And close the template.
echo '
			</div>
		<span class="botslice"><span></span></span>
	</div>';

// And the footer
template_footer();
?>
