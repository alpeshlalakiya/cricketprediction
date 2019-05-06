import axios from 'axios';

export const HTTP = axios.create({
    baseURL: process.env.ROOT_API,
    headers: {
        "Content-Type": "application/json"
    }
});