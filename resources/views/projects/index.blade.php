<!DOCTYPE html>
<html>
<head>
	<title>Projects</title>
</head>
<body>
<ul>
	@forelse($projects as $project)
	<li>
		<a href="{{ $project->path() }}"> {{$project->title}} </a>
	</li>
	@empty
	<li>No Ptojects Yet!</li>
	@endforelse
</ul>

</body>
</html>