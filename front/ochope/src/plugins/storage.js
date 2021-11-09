
const storage = {

  set: function(variableName, value) {
    const json = JSON.stringify(value);
    window.localStorage.setItem(variableName, json);
  },

  get: function(variableName) {
    const json = window.localStorage.getItem(variableName);
    if(json != undefined) {

      const value = JSON.parse(json);
      return value;
    }

    return false;
  },

  unset: function(variableName) {
    window.localStorage.removeItem(variableName);
  }

}

export default storage;
