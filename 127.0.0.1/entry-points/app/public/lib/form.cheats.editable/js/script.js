/*
Copyright MIT 2016 Lcf.vs
https://github.com/Lcfvs/form.cheats
*/
void function(global) {
    'use strict';
        
    var
    main;
    
    main = function() {
        var
        forEach,
        editable,
        onButton,
        onClick,
        onFieldset,
        onTextarea,
        onInput;
        
        forEach = Function.bind.bind(Function.call)(Array.prototype.forEach);
        
        editable = function(form, next) {
            var
            buttons,
            textareas;
            
            if (!form.classList.contains('editable')) {
                return next();
            }
            
            buttons = form.querySelectorAll('.edit');
            textareas = form.querySelectorAll('textarea');
            
            forEach(buttons, onButton);
            forEach(textareas, onTextarea);
            
            next();
        };
        
        onButton = function(button) {
            button.addEventListener('click', onClick);
        };
        
        onClick = function() {
            var
            form,
            fieldsets;
            
            form = this.form;
            fieldsets = form.querySelectorAll('fieldset');
            form.classList.toggle('enabled');
            forEach(fieldsets, onFieldset);
        };
        
        onFieldset = function(fieldset) {
            if (fieldset.disabled) {
                return fieldset.removeAttribute('disabled');
            }
            
            fieldset.setAttribute('disabled', 'disabled');
        };
        
        onTextarea = function(textarea) {
            textarea.addEventListener('input', onInput);
            onInput.call(textarea);
        };
        
        onInput = function() {
            this.style.height = '1px';
            this.style.height = this.scrollHeight + 'px';
        };
        
        return editable;
    };
    
    if (typeof global.define === 'function' && global.define.AMD) {
        return global.define('form.cheats.editable', main);
    }
    
    global['form.cheats.editable'] = main();
}(this);
