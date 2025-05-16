import React, { createContext, useContext, useState } from 'react';

type AuthContextType = {
    user: string | null;
    isLoggedIn: boolean;
    login: (username: string) => void;
    logout: () => void;
};

const AuthContext = createContext<AuthContextType>({
    user: null,
    login: () => { },
    logout: () => { },
    isLoggedIn: false,
});

export const AuthProvider = ({ children }: { children: React.ReactNode }) => {
    const [user, setUser] = useState<string | null>(null);
    const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);

    const login = (username: string) => {
        setUser(username);
        setIsLoggedIn(true);
    }
    const logout = () => {
        setUser(null);
        setIsLoggedIn(false);
    }

    return (
        <AuthContext.Provider value={{ user, login, logout, isLoggedIn }}>
            {children}
        </AuthContext.Provider>
    );
};

// Hook para usar facilmente
export const useAuth = () => useContext(AuthContext);
