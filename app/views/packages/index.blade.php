@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="columns">
            <h2>Packages</h2>
                <div id="packages"></div>

                <script type="text/template" id="packages-tmpl-2">
                    hi
                </script>

                <script type="text/template" id="packages-tmpl">
                    <% _.each( packages, function(pkg) { %>
                        <div class="package">
                            <div class="summary">
                                <button class="usages button small right">&#9733; <%= Object.keys(pkg.usages).length %></button>
                                <h3><a href="<%= pkg.homepage %>" target="_blank"><%= pkg.name %></a></h3>
                                <p><%= pkg.description %></p>
                            </div>
                            <div class="usages" style="display:none">
                                <ul>
                                    <% _.each( pkg.usages, function(version, usage) { %>
                                        <li><a href="https://bitbucket.org/npmweb/<%= usage %>" target="_blank"><%= usage %></a>: <%= version %></li>
                                    <% }) %>
                                </ul>
                            </div>
                        </div>
                    <% }) %>
                </script>
            </ul>
        </div>
    </div>
@stop

@section('js')
<script type="text/javascript">
var pu = pu || {};
pu.baseUrl = {{ json_encode(url()) }};

require(['backbone','jquery'], function(Backbone,$) {

    pu.Package = Backbone.Model.extend({});

    pu.PackageCollection = Backbone.Collection.extend({
        model: pu.Package,
        url: pu.baseUrl,
        initialize: function() {
            this.fetch({reset:true});
        },
        parse: function(response) {
            return response.models;
        }
    });

    pu.PackageListView = Backbone.View.extend({
        el: $('#packages'),
        template: $('#packages-tmpl').html(),
        initialize: function( packageCollection ) {
            this.packageCollection = packageCollection;
            this.packageCollection.on('reset', this.render, this );
        },
        render: function() {
            this.$el.html( _.template( this.template, {
                packages: this.packageCollection.toJSON()
            }));
        },
        events: {
            'click div.summary a': function(evt) { evt.stopPropagation() },
            'click div.summary': 'toggleUsages'
        },
        toggleUsages: function(evt) {
            $(evt.target).closest('div.package').find('div.usages').toggle();
        }
    });

    pu.packageCollection = new pu.PackageCollection();
    pu.packageListView = new pu.PackageListView( pu.packageCollection );
});

</script>
@stop