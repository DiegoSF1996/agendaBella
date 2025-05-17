import React, { createContext, useContext, useState, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';

type AuthContextType = {
  user: string | null;
  isLoggedIn: boolean;
  tipoUsuario: 'pf' | 'pj' | null;
  login: (username: string, tipoUsuario: 'pf' | 'pj') => Promise<void>;
  logout: () => Promise<void>;
};

const AuthContext = createContext<AuthContextType>({
  user: null,
  isLoggedIn: false,
  tipoUsuario: null,
  login: async () => {},
  logout: async () => {},
});

export const AuthProvider = ({ children }: { children: React.ReactNode }) => {
  const [user, setUser] = useState<string | null>(null);
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);
  const [tipoUsuario, setTipoUsuario] = useState<'pf' | 'pj' | null>(null);

  useEffect(() => {
    const loadStoredUser = async () => {
      try {
        const storedData = await AsyncStorage.getItem('@userData');
        if (storedData) {
          const parsed = JSON.parse(storedData);
          setUser(parsed.username);
          setTipoUsuario(parsed.tipoUsuario);
          setIsLoggedIn(true);
        }
      } catch (err) {
        console.error('Erro ao carregar dados do AsyncStorage', err);
      }
    };

    loadStoredUser();
  }, []);

  const login = async (username: string, tipo: 'pf' | 'pj') => {
    try {
      const userData = JSON.stringify({ username, tipoUsuario: tipo });
      await AsyncStorage.setItem('@userData', userData);
      setUser(username);
      setTipoUsuario(tipo);
      setIsLoggedIn(true);
    } catch (err) {
      console.error('Erro ao salvar usuário no AsyncStorage', err);
    }
  };

  const logout = async () => {
    try {
      await AsyncStorage.removeItem('@userData');
      setUser(null);
      setTipoUsuario(null);
      setIsLoggedIn(false);
    } catch (err) {
      console.error('Erro ao remover usuário do AsyncStorage', err);
    }
  };

  return (
    <AuthContext.Provider value={{ user, isLoggedIn, tipoUsuario, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
