import React, { useEffect } from 'react';
import { useAuth } from '../context/AuthContext';
import { useRouter } from 'expo-router';

export default function Logout() {
    const { logout } = useAuth();
    const router = useRouter();

    useEffect(() => {
        logout();
        router.replace('/login'); // redireciona para login depois do logout
    }, []);

    return null; // nada para renderizar
}
