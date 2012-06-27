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
		SELECT l.id_language, l.name, l.id_member, t.id_member, t.id_language, t.can_update, m.id_member, m.real_name
			FROM language.languages
			LEFT JOIN language.permission_languages AS t ON (l.id_member = t.id_member)
			LEFT JOIN {db_prefix}members AS m ON (m.id_member = t.id_member)
			WHERE t.can_update = {int:can_update}
			ORDER BY name ASC
	',
	array(
		'can_update' => 1
	)
);

	// Walk through the results
	$languages = array();
	while ($lang = $smcFunc['db_fetch_row']($query_languages))
	{
		if (!isset($languages[$lang['name']]))
			$languages[$lang['name']] = array();
		$languages[$lang['name']][] = $row;
	}
		
	foreach ($languages as $key => $translators)
	{
		// Show the name of the language.
		echo '
				<br /><strong>' . $key . '</strong><br />';
		foreach ($translators as $translator)
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

