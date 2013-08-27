
<!-- Templates: start -->

<script type="text/html" id="template_execution_diag">
	<li class="button" data-toggle="output"><span class="title">Output:</span> <span class="time_queries">{{=output_size}}</span></li>
	<li class="button last-of-type" data-toggle="queries" title="Number of queries / Execution time">
		<span class="title">SQL:</span>
		{{ if (queries.length) { }}
			<span class="time_queries">{{=queries.length}}<span class="divider">/</span>{{=time_queries}} ms</span>
		{{ } else { }}
			<em>none</em>
		{{ } }}
	</li>
	<li class="execution help" title="Script execution / Laravel total">
		<span class="title">Execution:</span> <span class="time">{{=time}} ms<span class="divider">/</span>{{=time_total}} ms</span>
	</li>
	<li class="memory help" title="Current memory / Memory peak">
		<span class="title">Memory:</span> <span class="memory">{{=memory}}<span class="divider">/</span>{{=memory_peak}}</span>
	</li>
</script>

<script type="text/html" id="template_execution_error">
	<li class="error">{{=error}}</li>
</script>

<script type="text/html" id="template_execution_loading">
	<li class="loading"></li>
</script>

<script type="text/html" id="template_execution_intro">
	<li class="stretch">
		<strong><code>{{=(navigator.appVersion.indexOf("Mac")!=-1 ? 'Cmd' : 'Ctrl') }}+Enter</code></strong>: execute
		<span class="divider"></span> <strong><code>Esc</code></strong>: reset view
		<span class="divider"></span> <strong><code>Tab</code></strong>: refocus editor
	</li>
	<li class="remember"><span class="button {{=(checked ? 'checked' : '') }}">remember code</span></li>
</script>

<script type="text/html" id="template_execution_intro">
	<li>{{=message}}</li>
</script>

<script type="text/html" id="template_request_error">
	{{=tmpl('execution_error', {error: 'Execution reqest failed with status: ' + status + ' ' + statusText } )}}
</script>

<script type="text/html" id="template_ended_unexpectedly">
	<li class="error">Code ended unexpectedly</li>
</script>

<script type="text/html" id="template_output">
	<li data-tab="output" class="output">
		{{ if (typeof output !== 'undefined' && output) { }}
			<pre class="output_holder">{{=output}}</pre>
		{{ } else if (typeof data !== 'undefined' && data) { }}
			{{=data}}
		{{ } else { }}
			<span class="muted"><em>Code produced no output</em></span>
		{{ } }}
	</li>

	<li data-tab="queries">
		<ul class="queries">
		{{ if (typeof queries !== 'undefined') { }}
			{{ if (queries && queries.length) { }}
				{{ for (var i = 0, l = queries.length; i < l; i++) { }}
					<li class="clearfix">
						<span class="time">{{=queries[i].time}} ms</span>
						<span class="query">{{=queries[i].query}}</span>
					</li>
				{{ } }}
			{{ } else { }}
				<li class="clearfix">
					<span class="muted"><em>No queries executed</em></span>
				</li>
			{{ } }}
		{{ } }}
		</ul>
	</li>
</script>

<!-- Templates: end -->
