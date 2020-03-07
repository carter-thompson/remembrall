import React, { useState } from "react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import RandomMemory from "./memory/RandomMemory";
import CreateMemory from "./memory/CreateMemory";

export default function AppRouter() {
  const [activeState, setActiveState] = useState<string>("home");

  const getActiveLink = (linkName: string): string => {
    return linkName === activeState ? "active" : "";
  };
  return (
    <Router>
      <div>
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
          <div className="collapse navbar-collapse" id="navbarSupportedContent">
            <ul className="navbar-nav mr-auto">
              <li className="nav-item">
                <Link
                  className={`nav-link ${getActiveLink("home")}`}
                  to="/"
                  onClick={() => setActiveState("home")}
                >
                  Home
                </Link>
              </li>
              <li className="nav-item">
                <Link
                  className={`nav-link ${getActiveLink("createMemory")}`}
                  to="/create"
                  onClick={() => setActiveState("createMemory")}
                >
                  Create Memory
                </Link>
              </li>
            </ul>
          </div>
        </nav>
        <hr />
        <Switch>
          <Route exact path="/">
            <RandomMemory />
          </Route>
          <Route exact path="/create">
            <CreateMemory />
          </Route>
        </Switch>
      </div>
    </Router>
  );
}
