
<!-- Templates: start -->

<script type="text/html" id="template_controls">
	<li class="button" data-show="output"><span class="title">Output:</span> <span class="time_queries">{{=niceBytesize(output_size)}}</span></li>
	<li class="button last-of-type" data-show="queries" title="Number of queries / Execution time">
		<span class="title">SQL:</span>
		{{ if (queries.length) { }}
			<span class="time_queries">{{=queries.length}}<span class="divider">/</span>{{=time_queries}} ms</span>
		{{ } else { }}
			<em>none</em>
		{{ } }}
	</li>
	<li class="execution help" title="Script execution / Laravel total">
		<span class="title">Execution:</span>
		<span class="time">{{=time}}<span class="divider">/</span>{{=time_total}}
		<span class="muted">ms</span></span>
	</li>
	<li class="memory help" title="Current memory / Memory peak">
		<span class="title">Memory:</span> <span class="memory">{{=niceBytesize(memory)}}<span class="divider">/</span>{{=niceBytesize(memory_peak)}}</span>
	</li>
</script>

<script type="text/html" id="template_controls_error">
	<li class="error">Execution failed: {{=status}} {{=statusText}}</li>
</script>

<script type="text/html" id="template_controls_loading">
	<li class="loading"></li>
</script>

<script type="text/html" id="template_controls_intro">
	<li class="stretch">
		<strong><code>{{=(navigator.appVersion.indexOf("Mac")!=-1 ? 'Cmd' : 'Ctrl') }}+Enter</code></strong>: execute
		<span class="divider"></span> <strong><code>Esc</code></strong>: reset view
		<span class="divider"></span> <strong><code>Tab</code></strong>: refocus editor
	</li>
	<li class="remember"><span class="button {{=(checked ? 'checked' : '') }}">remember code</span></li>
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
		{{ } else if (typeof error === 'undefined') { }}
			<span class="muted"><em>Code produced no output</em></span>
		{{ } }}

		{{ if (typeof error !== 'undefined' && error && typeof error.message !== 'undefined') { }}
			<div class="error clearfix">
				{{ if (!/eval\(\)'d code/i.exec(error.file)) { }}
					<span class="file">{{=error.file}}</span>
				{{ } }}
				<span class="line">Line <strong>{{=error.line}}</strong></span>
				<span class="message">{{=error.message}}</span>
			</div>
		{{ } }}
	</li>

	<li data-tab="queries">
		<table class="queries">
		{{ if (typeof queries !== 'undefined') { }}
			{{ if (queries && queries.length) { }}
				{{ for (var i = 0, l = queries.length; i < l; i++) { }}
					<tr>
						<td class="time">{{=queries[i].time}} ms</td>
						<td class="query">{{=queries[i].query}}</td>
					</tr>
				{{ } }}
			{{ } else { }}
				<tr>
					<td class="muted"><em>No queries executed</em></td>
				</tr>
			{{ } }}
		{{ } }}
		</table>
	</li>
</script>

<!-- Templates: end -->
