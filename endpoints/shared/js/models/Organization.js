var cs = cs || {};

define(
	['backbone','../utils'],
	function() {
		cs.Organization = Backbone.Model.extend({});

		cs.OrganizationCollection = Backbone.Collection.extend({
			model: cs.Organization,
			initialize: function( param ) {
				if( _.isArray(param) ) {
					this.parse({models:param});
				} else {
					this.parentOrgId = param;
					this.fetch({reset:true});
				}
			},
			url: function() {
				return cs.baseUrl
					+ '/organizations?'
					+ (this.parentOrgId ? 'org='+this.parentOrgId : '')
					+ cs.bustCache(true);
			},
			parse: function(response) {
				return response.models;
			}
		});
	}
);
