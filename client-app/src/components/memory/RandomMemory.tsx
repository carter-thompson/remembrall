import React, { useState } from "react";
import { Memory } from "../../shared/types";

export default function RandomMemory() {
  const [memory, setMemory] = useState<Memory | undefined>(undefined);
  const [error, setError] = useState<string>("");

  const fetchData = async () => {
    await fetch("http://127.0.0.1:80/memory/random", {
      method: "GET",
      mode: "cors"
    })
      .then((response: Response) => {
        return response.json()
      })
      .then((memory: Memory)=> {
        setMemory(memory);
      })
      .catch(error => {
        setError(error);
      });
  };

  return (
    <>
      {memory && (
        <div>
          <p>{memory.data}</p>
          <p>Id: {memory.id}</p>
          <p>Date Created: {memory.dateCreated}</p>
        </div>
      )}
      <button type="button" className="btn btn-success" onClick={fetchData}>
        Random Memory
      </button>
      {error.length > 0 && <p>Error: {error}</p>}
    </>
  );
}
