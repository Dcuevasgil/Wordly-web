import { BrowserRouter, Routes, Route } from "react-router-dom";

import LoginPage from "./modules/auth/pages/LoginPage";

import Dashboard from "./modules/learn/pages/Dashboard";
import DashboardHome from "./modules/learn/pages/DashboardHome";
import Settings from "./modules/learn/pages/Settings";
import Messages from "./modules/learn/pages/Messages";
import Practice from "./modules/learn/pages/Practice";


import PrivateRoute from "./router/PrivateRoute";
import PublicRoute from "./router/PublicRoute";
import UserLevelModal from "./modules/onboarding/components/modals/UserLevelModal";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route
          path="/"
          element={
            <PublicRoute>
              <LoginPage />
            </PublicRoute>
          }
        />

        <Route path="/onboarding" element={<UserLevelModal />} />

        <Route
          path="/dashboard"
          element={
            <PrivateRoute>
              <Dashboard />
            </PrivateRoute>
          }
        >
          <Route index element={<DashboardHome />} />
          <Route path="settings" element={<Settings />} />
          <Route path="messages" element={<Messages />} />
          <Route path="practice" element={<Practice />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;