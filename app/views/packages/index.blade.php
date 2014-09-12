@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="columns">
            <h2>Packages</h2>
                <p>
                    Composer packages used across all of <a href="https://bitbucket.org/{{{ $username }}}">{{{ $username }}}</a>'s applications. Data last updated {{{ $lastUpdated }}}.
                    <a href="https://github.com/npmweb/package-usage">View on GitHub.</a>
                </p>

                <div id="search"></div>
                <script type="text/template" id="search-tmpl">
                    <input type="search" id="search" placeholder="Search" />
                </script>

                <div id="packages"></div>
                <script type="text/template" id="packages-tmpl">
                    <% _.each( packages, function(pkg) { %>
                        <div class="package">
                            <div class="summary">
                                <button class="usages button small right">&#9733; <%= Object.keys(pkg.usages).length %></button>
                                <h3><a href="<%= pkg.homepage %>" target="_blank"><%= pkg.name %></a></h3>
                                <p><%= pkg.description %></p>
                            </div>
                            <div class="usages" style="display:none">
                                <p>Used in <%= pu.pluralize( pkg.usages, 'webapp' ) %>:</p>
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
<script type="application/json" id="packageData">{{{ json_encode($packages) }}}</script>
<script type="text/javascript">
var pu = pu || {};
pu.baseUrl = {{ json_encode(url()) }};

require(['underscore','backbone','jquery','../js/utils'], function(_,Backbone,$) {

    pu.packages =JSON.parse(_.unescape($('#packageData').text()));

    pu.Package = Backbone.Model.extend({});

    pu.PackageCollection = Backbone.Collection.extend({
        model: pu.Package,
        url: pu.baseUrl,
        initialize: function(data) {
            this.fullPackages = data;
            this.reset(this.fullPackages);
            // this.fetch({reset:true});
        },
        // parse: function(response) {
        //     this.fullPackages = response.models;
        //     return this.fullPackages;
        // },
        filter: function(query) {
            var terms = query.toLowerCase().split(/\W+/);
            var filteredPackages = _.filter( this.fullPackages, function(pkg) {
                return _.some( terms, function(term) {
                    return (-1 != pkg.name.toLowerCase().indexOf(term))
                        || (null == pkg.description
                            ? false
                            : (-1 != pkg.description.toLowerCase().indexOf(term)));
                });
            });

            this.reset(filteredPackages);
        }
    });

    pu.SearchView = Backbone.View.extend({
        el: $('#search'),
        template: $('#search-tmpl').html(),
        initialize: function( packageCollection ) {
            this.packageCollection = packageCollection;
            this.render();
        },
        render: function() {
            this.$el.html( _.template( this.template, {
            }));
        },
        events: {
            'keyup #search': 'search'
        },
        search: function(evt) {
            var query = $(evt.target).val();
            this.packageCollection.filter(query);
        }
    });

    pu.PackageListView = Backbone.View.extend({
        el: $('#packages'),
        template: $('#packages-tmpl').html(),
        initialize: function( packageCollection ) {
            this.packageCollection = packageCollection;
            this.packageCollection.on('reset', this.render, this );
            this.render();
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

    pu.packageCollection = new pu.PackageCollection( pu.packages );
    pu.searchView = new pu.SearchView( pu.packageCollection );
    pu.packageListView = new pu.PackageListView( pu.packageCollection );
});

</script>
@stop