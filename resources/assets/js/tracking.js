module.exports = {

    searchTerm(searchType, searchTerm, currentURL) {
        axios.post(`${location.href}/tracking/searchterm`, {
            term: searchTerm,
            type: searchType,
            url: currentURL
        });
    }

};