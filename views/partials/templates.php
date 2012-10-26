
<!-- Templates: start -->

<script type="text/html" id="template_execution_diag">
	<li><em>Execution:</em> <span class="time">{{=time}}ms</span></li>
	<li><em>Total:</em> <span class="time_total">{{=time_total}}ms</span></li>
	<li><em>Memory:</em> <span class="memory">{{=memory}}</span></li>
	<li><em>Memory peak:</em> <span class="memory_peak">{{=memory_peak}}</span></li>
</script>

<script type="text/html" id="template_execution_error">
	<li class="error">{{=error}}</li>
</script>

<script type="text/html" id="template_execution_loading">
	<li class="loading"></li>
</script>

<script type="text/html" id="template_execution_intro">
	<li><strong><code>{{=(navigator.appVersion.indexOf("Mac")!=-1 ? 'Cmd' : 'Ctrl') }}+Enter</code></strong>: run your code
	<span class="divider"></span> <strong><code>Esc</code></strong>: reset view</li>
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

<script type="text/html" id="template_no_output">
	<em class="no_output">Code produced no output</em>
</script>

<script type="text/html" id="template_output">
	<pre class="output_holder">{{=data}}</pre>
</script>

<!-- Templates: end -->
