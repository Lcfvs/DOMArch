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
        documents,
        middlewares,
        cheats,
        forms,
        demethodize,
        proto,
        forEach,
        indexOf,
        push,
        listen,
        onMutation,
        onNode,
        onForm,
        next;
        
        documents = [];
        middlewares = [];
        cheats = Object.create(null);
        forms = [];
        
        demethodize = Function.bind.bind(Function.call);
        proto = Array.prototype;
        forEach = demethodize(proto.forEach);
        indexOf = demethodize(proto.indexOf);
        push = demethodize(proto.push);
       
        cheats.use = function(middleware) {
            push(middlewares, middleware);
        };
        
        cheats.observe = function(document) {
            var
            observer;
            
            if (indexOf(documents, document) > -1) {
                return;
            }
            
            push(documents, document);
            
            observer = new global.MutationObserver(listen);
            
            observer.observe(document, {
                childList: true,
                subtree: true
            });
            
            forEach(document.forms, onForm);
        };
        
        listen = function(mutations) {
            forEach(mutations, onMutation);
        };
        
        onMutation = function(mutation) {
            var
            nodes;
            
            nodes = mutation.addedNodes;
            
            if (!nodes.length) {
                return;
            }
            
            forEach(nodes, onNode);
        };
        
        onNode = function(node) {
            forEach(node.ownerDocument.forms, onForm);
        };
        
        onForm = function(form) {
            if (indexOf(forms, form) > -1) {
                return;
            }
            
            push(forms, form);
            next(form);
        };
        
        next = function(form) {
            var
            middleware;
            
            middleware = middlewares[indexOf(middlewares, this) + 1];
            
            if (!middleware) {
                return;
            }
            
            middleware(form, next.bind(middleware, form));
        };
        
        return cheats;
    };
    
    if (typeof global.define === 'function' && global.define.AMD) {
        return global.define('form.cheats', main);
    }
    
    global['form.cheats'] = main();
}(this);
