import { View, Text } from 'react-native';
import { Link } from 'expo-router';
import { useAuth } from '@/context/AuthContext';
import LoginScreen from './login/_layout';
export default function Index() {
    const { isLoggedIn } = useAuth();
    return (
        <>
            {!isLoggedIn && (
                <>
                    <LoginScreen/>
                </>
            )}
        </>
    )
}