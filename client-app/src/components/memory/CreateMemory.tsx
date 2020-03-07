import React, { useState, ChangeEvent } from "react";
import { Memory } from "../../shared/types";

export default function CreateMemory(): JSX.Element {
  const [memory, setMemory] = useState<Memory>({} as Memory);
  const [savedMemory, setSavedMemory] = useState<Memory | undefined>(undefined);
  const postMemory = async (memory: Memory) => {
    await fetch("http://127.0.0.1:80/memory", {
      method: "POST",
      mode: "no-cors",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(memory)
    })
      .then((data: Response) => {
        return data.json();
      })
      .then((json: Memory) => setSavedMemory(json))
      .catch((reason: any) => {
        console.error(reason);
      });
  };
  const onSaveMemory = () => {
    postMemory(memory);
  };

  const updateMemory = (event: ChangeEvent<HTMLInputElement>) => {
    memory.data = event.target.value;
    setMemory(memory);
  };
  return (
    <div>
      <p>{savedMemory?.id}</p>
      <p>{savedMemory?.data}</p>
      <p>{savedMemory?.dateCreated}</p>
      <label>Memory:</label>
      <input
        type="text"
        value={memory.data}
        onChange={updateMemory}
        name="memoryText"
      />
      <button
        type={"submit"}
        value="submit"
        name="submit"
        onClick={onSaveMemory}
        className="btn btn-success"
      >
        Submit
      </button>
    </div>
  );
}
