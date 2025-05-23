import React, { createContext, useContext, useState, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';

type AuthContextType = {
  user: string | null;
  isLoggedIn: boolean;
  tipoUsuario: 'pf' | 'pj' | null;
  token: string | null;
  setToken: (token: string | null) => void;
  login: (username: string, tipoUsuario: 'pf' | 'pj', token: string) => Promise<void>;
  logout: () => Promise<void>;
};

const AuthContext = createContext<AuthContextType>({
  user: null,
  isLoggedIn: false,
  tipoUsuario: null,
  token: null,
  setToken: () => {},
  login: async () => {},
  logout: async () => {},
});

export const AuthProvider = ({ children }: { children: React.ReactNode }) => {
  const [user, setUser] = useState<string | null>(null);
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);
  const [tipoUsuario, setTipoUsuario] = useState<'pf' | 'pj' | null>(null);
  const [token, setToken] = useState<string | null>(null);

  useEffect(() => {
    const loadStoredUser = async () => {
      try {
        const storedData = await AsyncStorage.getItem('@userData');
        if (storedData) {
          const parsed = JSON.parse(storedData);
          console.log('Dados carregados do AsyncStorage:', parsed);
          setUser(parsed.username);
          setTipoUsuario(parsed.tipoUsuario);
          setIsLoggedIn(true);
          setToken(parsed.token);
        }
      } catch (err) {
        console.error('Erro ao carregar dados do AsyncStorage', err);
      }
    };

    loadStoredUser();
  }, []);

  const login = async (username: string, tipo: 'pf' | 'pj', token: string) => {
    try {
      const userData = JSON.stringify({ username, tipoUsuario: tipo, token, isLoggedIn: true });
      await AsyncStorage.setItem('@userData', userData);
      setUser(username);
      setTipoUsuario(tipo);
      setIsLoggedIn(true);
      setToken(token);
      
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
      setToken(null);
    } catch (err) {
      console.error('Erro ao remover usuário do AsyncStorage', err);
    }
  };

  return (
    <AuthContext.Provider value={{ user, isLoggedIn, tipoUsuario, token, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
