/*
 * JSON Tree Viewer
 * http://github.com/summerstyle/jsonTreeViewer
 *
 * Copyright 2017 Vera Lobacheva (http://iamvera.com)
 * Released under the MIT license (LICENSE.txt)
 */

'use strict';

var jsonTreeViewer = (function() {

    /* Utilities */
    var utils = App.utils;
    
    var treeWrapper = document.getElementById("tree");
    var tree = jsonTree.create({}, treeWrapper);
    
    // Menu
    var menu = new App.Menu(utils.dom.id('nav'), {
        'expand' : function() {
			loading.show();
			setTimeout(function(){ //den pezei to loading alios
				tree.expand();
				loading.hide();
			}, 100);
        },
        'collapse' : function() {
			loading.show();
			setTimeout(function(){ //den pezei to loading alios
				tree.collapse();
				loading.hide();
			}, 100);
        },
        'find_and_mark' : function() {
			loading.show();
			setTimeout(function(){ //den pezei to loading alios
				find_nodes_form.show();
				loading.hide();
			}, 100);
        },
        'unmark_all' : function() {
			loading.show();
			setTimeout(function(){ //den pezei to loading alios
				tree.unmarkAll();
				loading.hide();
			}, 100);
        },
    });
 

    /* Find nodes form */
    var find_nodes_form = new App.Window({
        content_el : utils.dom.id('find_nodes_form'),
        overlay : true,
        js_module : function(self) {
            var form = self.content_el,
                search_type_radio = {
                    label_name : document.getElementById('nodes_search_by_label'),
                    node_type : document.getElementById('nodes_search_by_type')
                },
                label_name_input = document.getElementById('search_by_label_name'),
                node_types_checkboxes = document.getElementsByName('nodes_type'),
                find_button = document.getElementById('find_button'),
                MATCHERS = {
                    BY_LABEL_NAME : function(labelName, node) {
                        return node.label === labelName;
                    },
                    BY_NODE_TYPE : function(nodeTypesArray, node) {
                        return nodeTypesArray.indexOf(node.type) >= 0;
                    }
                };

            function find(e) {
                var matcher;
				
                e.preventDefault();

                if (search_type_radio.label_name.checked) {
                    var label_name_value = label_name_input.value.trim();

                    if (!label_name_value) {
                        return;
                    }
                    matcher = MATCHERS.BY_LABEL_NAME.bind(null, label_name_value);
                } else if (search_type_radio.node_type.checked) {
                    var node_type_values = [];

                    for (var i = 0, c = node_types_checkboxes.length; i < c; i++) {
                        if (node_types_checkboxes[i].checked) {
                            node_type_values.push(node_types_checkboxes[i].value);
                        }
                    }

                    if (!node_type_values.length) {
                        return;
                    }

                    matcher = MATCHERS.BY_NODE_TYPE.bind(null, node_type_values);
                }

                if (!matcher) {
                    return;
                }

				loading.show();
				setTimeout(function(){ //den pezei to loading alios
					tree.findAndHandle(matcher, function(node) {
						node.mark();
						node.expandParent('isRecursive');
					});
					loading.hide();
				}, 100);

                self.hide();
            }
            
            find_button.addEventListener('click', find, false);
        }
    });
 
    return {
        parse : function(json_str) {
            var temp;
            
            try {
                temp = JSON.parse(json_str);
            } catch(e) {
                alert(e);
            }
            
            tree.loadData(temp);
        },
        no_parse : function(json) {
            tree.loadData(json);
        }
    };
})();
