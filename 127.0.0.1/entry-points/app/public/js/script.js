void function(global) {
    'use strict';

    var lib,
        cheats;

    lib = global.lib;
    cheats = global['form.cheats'];

    lib.middlewares.forEach(cheats.use);
    cheats.observe(global.document);
}(this);