import axios from "axios";
export default {
    GET_COMMAND: 'GET',
    POST_COMMAND: 'POST',
    PUT_COMMAND: 'PUT',
    PATCH_COMMAND: 'PATCH',
    DELETE_COMMAND: 'DELETE',
    apiBasePath: 'http://127.0.0.1:8000/v1',
    callApi: async function(requestType='GET', url, params={}, headers={}) {
        url = this.apiBasePath + url;
        const methodName = requestType.toUpperCase();
        if (methodName === 'GET') {
            return await axios.get(url, params, headers)
                .then(response => {
                    return response;
                })
                .catch(error => {
                    return error;
                });
        } else if (methodName === 'POST') {
            return await axios.post(url, params, headers)
                .then(response => {
                    return response;
                })
                .catch(error => {
                    return error;
                });
        } else if ((methodName === 'PUT') || (methodName === 'PATCH')) {
            return await axios.put(url, params, headers)
                .then(response => {
                    return response;
                });
        } else if (methodName === 'DELETE') {
            return await axios.delete(url, params, headers)
                .then(response => {
                    return response;
                });
        } else {
            return false;
        }
    }
}
