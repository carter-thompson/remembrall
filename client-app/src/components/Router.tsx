import React from 'react';
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from 'react-router-dom';
import RandomMemory from './memory/RandomMemory';
import CreateMemory from './memory/CreateMemory';


export default function AppRouter() {
    return (
        <Router>
            <div>
                <ul>
                    <li>
                        <Link to='/'>Home</Link>
                    </li>
                    <li>
                        <Link to='/create'>Create Memory</Link>
                    </li>
                </ul>
                <hr />
                
                <Switch>
                    <Route exact path='/'>
                        <RandomMemory/>
                    </Route>
                    <Route exact path='/create'>
                        <CreateMemory/>
                    </Route>
                </Switch>
            </div>
        </Router>
    )
}