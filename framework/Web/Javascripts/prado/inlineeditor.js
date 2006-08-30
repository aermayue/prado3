Prado.WebUI.TInPlaceTextBox = Base.extend(
{
	isSaving : false,
	isEditing : false,
	editField : null,

	constructor : function(options)
	{
		this.options = Object.extend(
		{
			LoadTextFromSource : false,
			TextMode : 'SingleLine'

		}, options || {});
		this.element = $(this.options.ID);

		this.initializeListeners();
	},

	/**
	 * Initialize the listeners.
	 */
	initializeListeners : function()
	{
		this.onclickListener = this.enterEditMode.bindAsEventListener(this);
	    Event.observe(this.element, 'click', this.onclickListener);
	    if (this.options.ExternalControl)
			Event.observe($(this.options.ExternalControl), 'click', this.onclickListener);
	},

	/**
	 * Changes the panel to an editable input.
	 * @param {Event} evt event source
	 */
	enterEditMode :  function(evt)
	{
	    if (this.isSaving) return;
	    if (this.isEditing) return;
	    this.isEditing = true;
		this.onEnterEditMode();
		this.createEditorInput();
		this.showTextBox();
		this.editField.disabled = false;
		if(this.options.LoadTextOnEdit)
			this.loadExternalText();
		Prado.Element.focus(this.editField);
		if (evt)
			Event.stop(evt);
    	return false;
	},

	showTextBox : function()
	{
		Element.hide(this.element);
		Element.show(this.editField);
	},

	showLabel : function()
	{
		Element.show(this.element);
		Element.hide(this.editField);
	},

	/**
	 * Create the edit input field.
	 */
	createEditorInput : function()
	{
		if(this.editField == null)
			this.createTextBox();

		this.editField.value = this.getText();
	},

	loadExternalText : function()
	{
		this.editField.disabled = true;
		this.onLoadingText();
		options = new Array('__InlineEditor_loadExternalText__', this.getText());
		request = new Prado.CallbackRequest(this.options.EventTarget, this.options);
		request.setCausesValidation(false);
		request.setParameter(options);
		request.options.onSuccess = this.onloadExternalTextSuccess.bind(this);
		request.options.onFailure = this.onloadExternalTextFailure.bind(this);
		request.dispatch();
	},

	/**
	 * Create a new input textbox or textarea
	 */
	createTextBox : function()
	{
		cssClass= this.element.className || '';
		inputName = this.options.EventTarget;
		options = {'className' : cssClass, name : inputName, id : this.options.TextBoxID};
		if(this.options.TextMode == 'SingleLine')
		{
			if(this.options.MaxLength > 0)
				options['maxlength'] = this.options.MaxLength;
			this.editField = INPUT(options);
		}
		else
		{
			if(this.options.Rows > 0)
				options['rows'] = this.options.Rows;
			if(this.options.Columns > 0)
				options['cols'] = this.options.Columns;
			if(this.options.Wrap)
				options['wrap'] = 'off';
			this.editField = TEXTAREA(options);
		}

		this.editField.style.display="none";
		this.element.parentNode.insertBefore(this.editField,this.element)

		//handle return key within single line textbox
		if(this.options.TextMode == 'SingleLine')
		{
			Event.observe(this.editField, "keydown", function(e)
			{
				 if(Event.keyCode(e) == Event.KEY_RETURN)
		        {
					var target = Event.element(e);
					if(target)
					{
						Event.fireEvent(target, "blur");
						Event.stop(e);
					}
				}
			});
		}

		Event.observe(this.editField, "blur", this.onTextBoxBlur.bind(this));
	},

	/**
	 * @return {String} panel inner html text.
	 */
	getText: function()
	{
    	return this.element.innerHTML;
  	},

	/**
	 * Edit mode entered, calls optional event handlers.
	 */
	onEnterEditMode : function()
	{
		if(typeof(this.options.onEnterEditMode) == "function")
			this.options.onEnterEditMode(this,null);
	},

	onTextBoxBlur : function(e)
	{
		text = this.element.innerHTML;
		if(this.options.AutoPostBack && text != this.editField.value)
			this.onTextChanged(text);
		else
		{
			this.element.innerHTML = this.editField.value;
			this.isEditing = false;
			if(this.options.AutoHide)
				this.showLabel();
		}
	},

	/**
	 * When the text input value has changed.
	 * @param {String} original text
	 */
	onTextChanged : function(text)
	{
		request = new Prado.CallbackRequest(this.options.EventTarget, this.options);
		request.setParameter(text);
		request.options.onSuccess = this.onTextChangedSuccess.bind(this);
		request.options.onFailure = this.onTextChangedFailure.bind(this);
		if(request.dispatch())
		{
			this.isSaving = true;
			this.editField.disabled = true;
		}
	},

	/**
	 * When loading external text.
	 */
	onLoadingText : function()
	{
		//Logger.info("on loading text");
	},

	onloadExternalTextSuccess : function(request, parameter)
	{
		this.isEditing = true;
		this.editField.disabled = false;
		this.editField.value = this.getText();
		Prado.Element.focus(this.editField);
	},

	onloadExternalTextFailure : function(request, parameter)
	{
		this.isSaving = false;
		this.isEditing = false;
		this.showLabel();
	},

	/**
	 * Text change successfully.
	 * @param {Object} sender
	 * @param {Object} parameter
	 */
	onTextChangedSuccess : function(sender, parameter)
	{
		this.isSaving = false;
		this.isEditing = false;
		if(this.options.AutoHide)
			this.showLabel();
		this.element.innerHTML = parameter == null ? this.editField.value : parameter;
		this.editField.disabled = false;
	},

	onTextChangedFailure : function(sender, parameter)
	{
		this.editField.disabled = false;
		this.isSaving = false;
		this.isEditing = false;
	}
});