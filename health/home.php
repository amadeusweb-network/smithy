<?php
contentBox(nodeValue(), cssUX::container . ' mt-3');
echo '<form method="get" action="./check/" target="spring_health" onsubmit="const action = $(event.submitter).data(\'action\'); if (action) this.action = action; return true;">' . NEWLINE;
$all = tagUX::checkbox('', '', true, ['onchange' => "$('.check-domain').prop('checked', $(this).prop('checked'));"]);
h2($all . getLink('All Domains', './'));

echo '<input type="submit" value="Check Health" data-action="./check/" />' . NEWLINE;
echo '<input type="submit" value="List Domains" data-action="./domains/" />' . NEWLINE;


bootstrapAndUX::colouredDiv('These domains are cached from www/whois/network/sites.tsv and rendered using datatables...', bootstrapAndUX::warning, nodeValue());

function get_color($yes) { return $yes ? 'dark bg-success' : ''; }
function folderLink($folder, $root = false) {
	$name = $folder == 'all' ? 'All Folders' : humanize($folder);
	$domain = getQueryParameter('domain');
	$qs = '/?domain=' . $domain . '&folder=' . $folder;
	$checkable = !$root && $folder != 'all';
	$cb = tagUX::checkbox('folder[]', $domain . '--' . $folder, $checkable, $checkable ? ['class' => 'check-folder'] : ['disabled' => 'disabled']);
	return $cb . ($root ? '' : ' &mdash; ') . getLink('<u>' . $name . '</u>', pageUrl('health/' . $qs), get_color(getQueryParameter('folder') == $folder))
		;
}

if ($domainId = getQueryParameter('domain')) {
	echo CBCO;
	$item = domain::$all[$domainId];
	variable('thisDomain', $item);

	if ($folderId = getQueryParameter('folder')) {
		h2('This Folder\'s Sites');

		

		h2('This Folder');
		echo folderLink($folderId, true) . BRNL;

		foreach ($item->subFolders as $folder) {
			if ($folderId != 'all' && $folderId != $folder) continue;
			$params = ['%subfol%' => $folder];
			$local = replaceItems($item->localBase, $params);
			$live = replaceItems($item->liveBase, $params);
			echo ' &mdash; ' . getLink($folder, '#') . ' &mdash;&gt; visit: ' . getLink($local, $local) . ' == ' . getLink($live, $live) . BRNL;
		}
		echo CBCO;
	}

	h2('This Domain\'s Folders', cssUX::m0);
	echo replaceItems('%1%%0%%checkbox% Folders:%0%%folders%', [BRNL, $item->heading,
		'checkbox' => tagUX::checkbox('', '', true, ['onchange' => "$('.check-folder').prop('checked', $(this).prop('checked'));"]),
		'folders' => folderLink('all') . BRNL . implode(BRNL, array_map(function ($fol) {  return folderLink($fol); }, $item->subFolders)),
	], WRAPREPLACE);
	echo CBCO;
}

if ($domainId) h2('This Domain', cssUX::m0);
$line = ($domainId ? '' : CBCO) . '%checkbox%%name%%nl%
mainSites:%nl%%sites%%nl%
';

foreach (domain::$all as $id => $item) {
	$item = domain::cast($item);
	if ($domainId && $domainId != $id) continue;
	variable('thisDomain', $item);

	echo replaceItems($line, [
		'nl' => BRNL,
		'checkbox' => tagUX::checkbox('domain[]', $id, !$domainId, ['class' => 'check-domain']),
		'name' => getLink($item->heading, pageUrl('health/?domain=' . $id), get_color($domainId == $id)),
		'sites' => implode(BRNL, array_map(function ($site) { 
				return ' &mdash; ' . getLink('<u>' . $site . '</u>', replaceNetworkUrls('%urlOf-spring%health/?site=' . $site), get_color(getQueryParameter('site') == $site))
					. ' &mdash;&gt; visit: ' . getSiteLink($site, variable('thisDomain'));
			}, $item->mainSites)),
	], WRAPREPLACE);
}

echo '</form>' . NEWLINE;
contentBox('end');
