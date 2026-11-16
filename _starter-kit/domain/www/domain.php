<?php
domain::add('legacy', __DIR__, domain::SkipList, new domain([
		'folder' => 'legacy/',
		'heading' => 'CS YM JE',
		'local' => 'http://localhost/legacy/%subfol%/%site%/',
		'live' => 'https://%site%.legacy.amadeusweb.in/',
		'local-base' => 'http://localhost/legacy/%subfol%/',
		'live-base' => 'https://%subfol%.legacy.amadeusweb.in/',
	],
	['%folder%www', '%folder%2013'], //'%folder%2005', '%folder%2023'],
	false,
));
