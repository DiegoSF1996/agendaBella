import { GestureHandlerRootView } from 'react-native-gesture-handler';
import { Drawer } from 'expo-router/drawer';
import { AuthProvider, useAuth } from '../context/AuthContext';
import { Text } from 'react-native';




function DrawerContent() {
  const { isLoggedIn, logout } = useAuth();

  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      {/* <Text>{isLoggedIn ? 'Logado' : 'Não logado'}</Text> */}
      <Drawer>
        <Drawer.Protected guard={!isLoggedIn} >
          <Drawer.Screen name="index" options={{ title: 'Inicio' }} />
          <Drawer.Screen name="login" options={{ title: 'Login' }} />
        </Drawer.Protected>
        <Drawer.Protected guard={isLoggedIn} >
          <Drawer.Screen name="home" options={{ title: 'Home' }} />
          <Drawer.Screen name='logout' />
        </Drawer.Protected>
      </Drawer>
    </GestureHandlerRootView>
  );
}


export default function Layout() {
  return (
    <AuthProvider>
      <DrawerContent />
    </AuthProvider>
  );
}
