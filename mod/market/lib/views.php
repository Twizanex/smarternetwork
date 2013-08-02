<?php
/**
 * Exerpt from engine/lib/views.php.
 */

/**
 * Convenience function for generating a form from a view in a standard location.
 *
 * This function assumes that the body of the form is located at "forms/$action" and
 * sets the action by default to "action/$action".  Automatically wraps the forms/$action
 * view with a <form> tag and inserts the anti-csrf security tokens.
 *
 * @tip This automatically appends elgg-form-action-name to the form's class. It replaces any
 * slashes with dashes (blog/save becomes elgg-form-blog-save)
 *
 * @example
 * <code>echo elgg_view_form('login');</code>
 *
 * This would assume a "login" form body to be at "forms/login" and would set the action
 * of the form to "http://yoursite.com/action/login".
 *
 * If elgg_view('forms/login') is:
 * <input type="text" name="username" />
 * <input type="password" name="password" />
 *
 * Then elgg_view_form('login') generates:
 * <form action="http://yoursite.com/action/login" method="post">
 *     ...security tokens...
 *     <input type="text" name="username" />
 *     <input type="password" name="password" />
 * </form>
 *
 * @param string $action    The name of the action. An action name does not include
 *                          the leading "action/". For example, "login" is an action name.
 * @param array  $form_vars $vars environment passed to the "input/form" view
 * @param array  $body_vars $vars environment passed to the "forms/$action" view
 *
 * @return string The complete form
 */
 
// 04/09/2013 - Created function.  No evidence that it is being used by the application.
function quebx_view_category_form($action, $category, $form_vars = array(), $body_vars = array()) {
	global $CONFIG;

	$defaults = array(
		'action' => $CONFIG->wwwroot . "action/$action/$category",
		'body' => elgg_view("forms/$action/$category", $body_vars)
	);

	$form_class = 'elgg-form-' . preg_replace('/[^a-z0-9]/i', '-', $action);

	// append elgg-form class to any class options set
	if (isset($form_vars['class'])) {
		$form_vars['class'] = $form_vars['class'] . " $form_class";
	} else {
		$form_vars['class'] = $form_class;
	}

	return elgg_view('input/form', array_merge($defaults, $form_vars));
}
