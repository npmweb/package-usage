var pu = pu || {};

pu.bustCache = function(alreadyInQueryString) {
  var string;
  if( alreadyInQueryString ) {
    string = '&';
  } else {
    string = '?';
  }
  return string+'bustcache='+(new Date()).getTime();
};

pu.pluralize = function( num, label ) {
  if( Array.isArray(num) ) {
    num = num.count;
  } else if( typeof num === 'object' ) {
    num = Object.keys(num).length;
  }
  if( 1 == num ) {
    return num+' '+label;
  }
  return num+' '+label+'s'; // dumb pluralization
}
