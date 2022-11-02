import http from 'k6/http';
import { check, group } from 'k6';

export default function () {
    group('Books CRUD', () => {
        const URL = `${__ENV.BASE_URL}/books`;

        const randomTitle = Math.random().toString(16).substr(2, 8) + " " + Math.random().toString(16).substr(2, 8);

        const payload = JSON.stringify({
            title: randomTitle,
            isbn: Math.random().toString(16).substr(2, 13),
        });

        const headerParams = {
            headers: {
                'Content-Type': 'application/json',
            }
        };

        const postResponse = http.post(URL, payload, headerParams);
        const bookId = JSON.parse(postResponse.body).data.id;

        check(postResponse, {
            'Status is correct': r => r.status === 201,
            'Response has ID': r => JSON.parse(r.body).data.id !== undefined,
        });

        const getOneResponse = http.get(URL + "/" + bookId, headerParams);

        check(getOneResponse, {
            'Status is correct': r => r.status === 200,
            'Title is correct': r => JSON.parse(r.body).data.title === randomTitle,
        });

        const getResponse1 = http.get(URL, headerParams);

        check(getResponse1, {
            'Status is correct': r => r.status === 200,
            'Length is correct': r => JSON.parse(r.body).data.length >= 1,
        });

        // PATCH
        const randomTitle2 = Math.random().toString(16).substr(2, 8) + " " + Math.random().toString(16).substr(2, 8);

        const patchPayload = JSON.stringify({
            title: randomTitle2,
            id: bookId,
        });

        const patchResponse = http.patch(URL + "/" + bookId, patchPayload, headerParams);

        check(patchResponse, {
            'Status is correct': r => r.status === 200,
            'New title is correct': r => JSON.parse(r.body).data.title === randomTitle2,
        });

        // DELETE

        const deleteResponse = http.del(URL + "/" + bookId, headerParams);

        check(deleteResponse, {
            'Status is correct': r => r.status === 200,
        });
        const getDeletedResponse = http.get(URL + "/" + bookId, headerParams);

        check(getDeletedResponse, {
            'Status is correct': r => r.status === 404,
        });

    });
}